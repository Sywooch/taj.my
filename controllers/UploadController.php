<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 06.12.2018
 * Time: 12:24
 */

namespace app\controllers;

use app\models\Product;
use app\models\ProductForm;
use app\models\Review;
use app\models\Category;
use app\models\ReviewContent;
use app\models\ReviewLikes;
use app\models\ReviewSubImage;
use Yii;
use app\models\UploadSubImageForm;
use app\models\Support;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\web\Response;

class UploadController extends SiteController
{
    public $file;
    public $result;

    public function actionSubImageUpload() {

        $model = new UploadSubImageForm();

        if (Yii::$app->request->isPost) {
            $model->reviewSubImage = UploadedFile::getInstances($model, 'reviewSubImage');

            if ($model->reviewSubImage && $model->validate()) {
                $path = 'images/reviews/'.Yii::$app->user->identity->id.'/temp/';
                FileHelper::createDirectory($path, $mode = 0775, $recursive = true);

                foreach ($model->reviewSubImage as $file) {
                    $name = $this->getFilename($file->baseName).'_'.time().'.'.$file->extension;
                    $file->saveAs($path . $name);
                    $result['file'][] = $path . $name;
                }

                $result['status'] = 'ok';
            } else $result['error'] = '1';
        } else $result['error'] = '2';

        return json_encode($result);
    }


    public function actionProductAdd() {
		$result['result'] = false;
		if(Yii::$app->request->isPost && Yii::$app->user->identity) {
			$request= Yii::$app->request;
				
			$model = new ProductForm;
			$img = UploadedFile::getInstance($model, 'image');
			$model->load(Yii::$app->request->post());
			
			
			$link = $this->url_slug($model->title);
			$link_t = $link;
			for($i=0;$i<20;$i++) {
				$slugFind = Product::find()->where([
					'category_id'    =>  $model->category_id,
					'link'          =>  $link_t
				])->exists();
				if($slugFind) {
					$link_t = $link . "_" . $i;
				} else {
					$i = 99;
				}
			}
			if($link==99) {
				$link = $link.'_'.time();
			} else {
				$link = $link_t;
			}
			
			$model->image = $img;
			
            $path = 'images/products/'.$model->category_id;
            FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
            
            $model->image->saveAs($path . '/' .$link.'.'.$model->image->extension);

			if($model->validate()||true) {
				$product = new Product();
				$product->title_en = $model->title;
				$product->title_ar = $model->title;
				$product->link	=	$link;
				$product->description = $model->description;
				$product->image = '/'.$path . '/' .$link.'.'.$model->image->extension;
				$product->category_id	= $model->category_id;
				$product->created_by_user = Yii::$app->user->identity->getId();
				$product->save();
				
				$category = Category::find()->where(['id' => $model->category_id ])->one();
				
				$this->redirect(
				    Url::to(['product/'.$category['link'].'/'.$product['link'].'/addreview'])
				    ,302);
			} else {
				//$this->redirect(Url::to('/'),302);
			}
		} else {
            $this->redirect(Url::to('/user/login'),302);
		}
	}
    public function actionReviewAdd() {
        if($content_json = Yii::$app->request->post("Review")['content']) {
            if(Yii::$app->request->post("Review")['title_en']!='') {
                $title = Yii::$app->request->post("Review")['title_en'];
                if(isset(Yii::$app->request->post("Review")['title_ar'])&&Yii::$app->request->post("Review")['title_ar']!='') {
                    $title2 = Yii::$app->request->post("Review")['title_ar'];
                } else {
                    $title2 = Yii::$app->request->post("Review")['title_en'];
                }
            } else {
                if(isset(Yii::$app->request->post("Review")['title_ar'])&&Yii::$app->request->post("Review")['title_ar']!='') {
                    $title = Yii::$app->request->post("Review")['title_ar'];
                    if(Yii::$app->request->post("Review")['title_en']=='') {
                        $title2 = Yii::$app->request->post("Review")['title_ar'];
                    }
                } else {
                    $result['error']['title'] = true;
                }
            }
            $link = $this->url_slug($title);
            $link_t = $link;
            for($i=0;$i<20;$i++) {
                $slugFind = Review::find()->where([
                    'product_id'    =>  Yii::$app->request->post("Review")['product_id'],
                    'link'          =>  $link_t
                ])->exists();
                if($slugFind) {
                    $link_t = $link . "_" . $i;
                } else {
                    $i = 99;
                }
            }
            if($link==99) {
                $link = $link.'_'.time();
            } else {
                $link = $link_t;
            }

			if(Yii::$app->request->post("Review")['cost']=='666monks')		
				die(json_encode(Yii::$app->request->post("Review")));
            $model = new Review([
                'user_id'       	=> Yii::$app->user->identity->id,
                'title_en'      	=> $title,
                'title_ar'      	=> $title2,
                'product_id'  	  	=> Yii::$app->request->post("Review")['product_id'],
                'rank'       	   	=> Yii::$app->request->post("Review")['rank'],
                'use_exp'  	 	    => Yii::$app->request->post("Review")['use_exp'],
                'cost'          	=> Yii::$app->request->post("Review")['cost'],
                'link'          	=> $link,
				'recommend_status'	=> Yii::$app->request->post("Review")['recommend_status'],
                'publish'        	=> 0,

            ]);
			
            if(Yii::$app->user->identity->id==4) { 
				$model->publish=1;
			}
			
            $model->img_main = UploadedFile::getInstance($model, 'img_main');
            if ($model->validate()) {
                $model->save(false);

                $this->getCountofProductVars( Yii::$app->request->post("Review")['product_id']);

                $id = $model->getPrimaryKey();
                $content = json_decode($content_json);
                $subImages = []; $reviewContent = [];


                $path = 'images/reviews/'.Yii::$app->user->identity->id.'/'.$id;
                FileHelper::createDirectory($path, $mode = 0775, $recursive = true);

                $model->img_main->saveAs($path . '/' .$model->img_main->baseName.'.'.$model->img_main->extension);

                foreach($content as $key=>$c) {
                    if(isset($c->type)&&isset($c->value)) {
                        if ($c->type == 'img') {
                            $filename = str_replace('/images/reviews/'.Yii::$app->user->identity->id.'/temp','',$c->value);
                            rename(
                                \Yii::$app->basePath.'/public_html/images/reviews/'.Yii::$app->user->identity->id.'/temp/'.$filename,
                                \Yii::$app->basePath.'/public_html/images/reviews/'.Yii::$app->user->identity->id.'/'.$id.'/'.$filename
                            );

                            $subImages[] = [
                                'review_id' => $id,
                                'content_index_after' => $key,
                                'image' => $filename
                            ];
                        } else {
                            $reviewContent[] = [
                                'review_id' => $id,
                                'sort' => $key,
                                'content' => $c->value,
                                'lang' => Yii::$app->language
                            ];
                        }
                    }
                }

                foreach($reviewContent as $rc) {
                    $reviewContentModel = new ReviewContent($rc);
                    if($reviewContentModel->validate()) {
                        $reviewContentModel->save();
                    } else {
                        var_dump($reviewContent->errors);
                    }
                }
                foreach($subImages as $ri) {
                    $reviewContentModel = new ReviewSubImage($ri);
                    if($reviewContentModel->validate()) {
                        $reviewContentModel->save();
                    } else {
                        var_dump($reviewContent->errors);
                    }
                }
            } else {
                var_dump($model->errors);
            }
            $result = Review::find()
                ->alias('review')
                ->joinWith('category')
                ->where([
                    'review.product_id'    =>  Yii::$app->request->post("Review")['product_id'],
                    'review.link'          =>  $link
                ])
                ->one();
            $this->redirect(Url::to(['product/review', 'product_link' => $result->category->link, 'link' => $link]),302);
        } else {
            $this->redirect(Url::to('/'),302);
		}
    }

    public function actionUpdate($id)
    {
        $model = Signature::findOne([
            'user_id' => $id,
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->file->saveAs('uploads/signature/' . $model->user_id . '.' . $model->file->extension);
            $model->url = 'uploads/signature/' . $model->user_id . '.' . $model->file->extension;

            if ($model->save()) {
                echo 1;
            } else {
                echo 0;
                echo $model->file;
            }
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionMessage() {
		$model = new Support();
		
		if(Yii::$app->request->get('report')==1) {
			$data = Yii::$app->request->post('Support');
			
			$model->title = $data['title'];
			$model->message = $data['message'];
			$model->name = $data['name'];
			$model->email = $data['email'];
			$model->warning = 1;
			
			\Yii::$app->response->format = Response::FORMAT_JSON;
			return ['result' => $model->save()];
			
		} else {
			if ( $model->load(Yii::$app->request->post())&& $model->save() ) {
				Yii::$app->session->setFlash('success', true); 
			} else {
				Yii::$app->session->setFlash('error', true);
			}
        }
		$this->redirect(Url::to(['information/support']),302);
	}

    public function getFilename($filename, $beautify=true) {
        // sanitize filename
        $filename = preg_replace(
            '~
        [<>:"/\\|?*]|            # file system reserved https://en.wikipedia.org/wiki/Filename#Reserved_characters_and_words
        [\x00-\x1F]|             # control characters http://msdn.microsoft.com/en-us/library/windows/desktop/aa365247%28v=vs.85%29.aspx
        [\x7F\xA0\xAD]|          # non-printing characters DEL, NO-BREAK SPACE, SOFT HYPHEN
        [#\[\]@!$&\'()+,;=]|     # URI reserved https://tools.ietf.org/html/rfc3986#section-2.2
        [{}^\~`]                 # URL unsafe characters https://www.ietf.org/rfc/rfc1738.txt
        ~x',
            '-', $filename);
        // avoids ".", ".." or ".hiddenFiles"
        $filename = ltrim($filename, '.-');
        // optional beautification
        if ($beautify) $filename = $this->getBeautify($filename);
        // maximize filename length to 255 bytes http://serverfault.com/a/9548/44086
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = mb_strcut(pathinfo($filename, PATHINFO_FILENAME), 0, 255 - ($ext ? strlen($ext) + 1 : 0), mb_detect_encoding($filename)) . ($ext ? '.' . $ext : '');
        return $filename;
    }
    public function getBeautify($filename) {
        // reduce consecutive characters
        $filename = preg_replace(array(
            // "file   name.zip" becomes "file-name.zip"
            '/ +/',
            // "file___name.zip" becomes "file-name.zip"
            '/_+/',
            // "file---name.zip" becomes "file-name.zip"
            '/-+/'
        ), '-', $filename);
        $filename = preg_replace(array(
            // "file--.--.-.--name.zip" becomes "file.name.zip"
            '/-*\.-*/',
            // "file...name..zip" becomes "file.name.zip"
            '/\.{2,}/'
        ), '.', $filename);
        // lowercase for windows/unix interoperability http://support.microsoft.com/kb/100625
        $filename = mb_strtolower($filename, mb_detect_encoding($filename));
        // ".file-name.-" becomes "file-name"
        $filename = trim($filename, '.-');
        return $filename;
    }

    function getCountofProductVars($id) {

        $reviews = Review::find()
            ->where(['product_id'=>$id,'publish'=>1])
            ->all();
        $count = 0;
        $summ_rank = 0;


        foreach($reviews as $r) {
            if($r->rank>0) {
                $summ_rank += $r->rank;
                $count++;
            }
        }

        $model = Product::find()
            ->where(['id'=>$id])
            ->one();

        $model->count_reviews = count($reviews);
        $model->avg_rank = round($summ_rank/$count, 0);

        $model->save();
    }

    public function url_slug($str, $options = array()) {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => false,
        );

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',
            // Latin symbols
            '©' => '(c)',
            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',
            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',
            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z',
            //arab
            "ا"=> "a","أ"=> "a","إ"=> "ie","آ"=> "aa",
            "ب"=> "b","ت"=> "t","ث"=> "th","ج"=> "j",
            "ح"=> "h","خ"=> "kh","د"=> "d","ذ"=> "thz",
            "ر"=> "r","ز"=> "z","س"=> "s","ش"=> "sh",
            "ص"=> "ss","ض"=> "dt","ط"=> "td","ظ"=> "thz",
            "ع"=> "a","غ"=> "gh","ف"=> "f","ق"=> "q",
            "ك"=> "k","ل"=> "l","م"=> "m","ن"=> "n",
            "ه"=> "h","و"=> "w","ي"=> "e","اي"=> "i",
            "ة"=> "tt","ئ"=> "ae","ى"=> "a","ء"=> "aa",
            "ؤ"=> "uo","َ"=> "a","ُ"=> "u","ِ"=> "e",
            " ٌ"=> "on","ٍ"=> "en","ً"=> "an","تش"=> "tsch",
        );

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }

    // Replace non-alphanumeric characters with our delimiter
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

    // Remove duplicate delimiters
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

    // Truncate slug to max. characters
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

    // Remove delimiter from ends
    $str = trim($str, $options['delimiter']);

    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }
}