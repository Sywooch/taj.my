<?php echo $header; ?>
<?php
  $css3_transitions_types  = array('fade', 'fadeUp', 'goDown', 'backSlide');
?>
<style type="text/css">
  .inline {
    display: inline;
  }
  .module_options_no_rborder {
    border-right: 0px !important;
    border-bottom: 0px !important;
  }
  .module_options {
    padding: 10px !important;
    border-bottom: 0px !important;
    background-color: #fff !important;
  }
  .module_options_empty {
    padding: 20px !important;
    border-top: 1px solid #ddd;
  }
</style>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="apply()" class="button"><span><?php echo $button_apply; ?></span></a><script language="javascript">function apply(){$('#form').append('<input type="hidden" id="apply" name="apply" value="1"  />'); $('#form').submit();}</script><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_banner; ?></td>
              <td class="left"><?php echo $entry_dimension; ?></td>
              <td class="left"><?php echo $entry_layout; ?></td>
              <td class="left"><?php echo $entry_position; ?></td>
              <td class="left"><?php echo $entry_status; ?></td>
              <td class="right"><?php echo $entry_sort_order; ?></td>
              <td></td>
            </tr>
          </thead>
          <?php $module_row = 0; ?>
          <?php foreach ($modules as $module) { ?>
          <tbody id="module-row<?php echo $module_row; ?>">
            <tr>
              <td class="left"><select name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][banner_id]">
                  <?php foreach ($banners as $banner) { ?>
                  <?php if ($banner['banner_id'] == $module['banner_id']) { ?>
                  <option value="<?php echo $banner['banner_id']; ?>" selected="selected"><?php echo $banner['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td class="left"><input type="text" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][width]" value="<?php echo $module['width']; ?>" size="3" />
                <input type="text" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][height]" value="<?php echo $module['height']; ?>" size="3"/>
                <?php if (isset($error_dimension[$module_row])) { ?>
                <span class="error"><?php echo $error_dimension[$module_row]; ?></span>
                <?php } ?></td>
              <td class="left"><select name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][layout_id]">
                  <?php foreach ($layouts as $layout) { ?>
                  <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                  <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][position]">
                  <?php if ($module['position'] == 'content_top') { ?>
                  <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                  <?php } else { ?>
                  <option value="content_top"><?php echo $text_content_top; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'content_bottom') { ?>
                  <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                  <?php } else { ?>
                  <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'column_left') { ?>
                  <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                  <?php } else { ?>
                  <option value="column_left"><?php echo $text_column_left; ?></option>
                  <?php } ?>
                  <?php if ($module['position'] == 'column_right') { ?>
                  <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                  <?php } else { ?>
                  <option value="column_right"><?php echo $text_column_right; ?></option>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][status]">
                  <?php if ($module['status']) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td class="right"><input type="text" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
              <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
            </tr>

            <tr>
              <td class="module_options module_options_no_rborder" rowspan="3"><?php echo $entry_items; ?></td>
              <td class="module_options module_options_no_rborder" colspan="2" rowspan="3">
                <select name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][items_desktop]">
                  <?php for ($i = 1; $i <= 12; $i++) {
                    ($module['items_desktop'] == $i) ? $active = 'selected' : $active = ''; ?>
                  <option value="<?php echo $i; ?>" <?php echo $active; ?>><?php echo $i; ?></option>
                  <?php } ?>
                </select> <span class="help inline"><?php echo $entry_items_desktop; ?></span><br />
                <select name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][items_desktop_small]">
                  <?php for ($i = 1; $i <= 12; $i++) {
                    ($module['items_desktop_small'] == $i) ? $active = 'selected' : $active = ''; ?>
                  <option value="<?php echo $i; ?>" <?php echo $active; ?>><?php echo $i; ?></option>
                  <?php } ?>
                </select> <span class="help inline"><?php echo $entry_items_desktop_small; ?></span><br />
                <select name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][items_tablet]">
                  <?php for ($i = 1; $i <= 12; $i++) {
                    ($module['items_tablet'] == $i) ? $active = 'selected' : $active = ''; ?>
                  <option value="<?php echo $i; ?>" <?php echo $active; ?>><?php echo $i; ?></option>
                  <?php } ?>
                </select> <span class="help inline"><?php echo $entry_items_tablet; ?></span><br />
                <select name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][items_tablet_small]">
                  <?php for ($i = 1; $i <= 12; $i++) {
                    ($module['items_tablet_small'] == $i) ? $active = 'selected' : $active = ''; ?>
                  <option value="<?php echo $i; ?>" <?php echo $active; ?>><?php echo $i; ?></option>
                  <?php } ?>
                </select> <span class="help inline"><?php echo $entry_items_tablet_small; ?></span><br />
                <select name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][items_mobile]">
                  <?php for ($i = 1; $i <= 12; $i++) {
                    ($module['items_mobile'] == $i) ? $active = 'selected' : $active = ''; ?>
                  <option value="<?php echo $i; ?>" <?php echo $active; ?>><?php echo $i; ?></option>
                  <?php } ?>
                </select> <span class="help inline"><?php echo $entry_items_mobile; ?></span><br />
              </td>
              <td class="module_options module_options_no_rborder">
                <?php echo $entry_autoplay; ?>
              </td>
              <td class="module_options" colspan="3">
                <?php if ($module['autoplay']) { ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][autoplay]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][autoplay]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][autoplay]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][autoplay]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?>
              </td>
            </tr>

            <tr>
              <td class="module_options module_options_no_rborder"><?php echo $entry_delay; ?></td>
              <td class="module_options" colspan="3">
                <select name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][delay]">
                  <?php for ($i = 1; $i <= 30; $i++) {
                      ($module['delay'] == $i) ? $active = 'selected' : $active = ''; ?>
                  <option value="<?php echo $i; ?>" <?php echo $active; ?>><?php echo $i; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>

            <tr>
              <td class="module_options module_options_no_rborder">
                <?php echo $entry_progress; ?>
              </td>
              <td class="module_options" colspan="3">
                <?php if ($module['progress']) { ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][progress]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][progress]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][progress]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][progress]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?>
              </td>
            </tr>

            <tr>
              <td class="module_options module_options_no_rborder">
                <?php echo $entry_navigation; ?>
              </td>
              <td class="module_options module_options_no_rborder" colspan="2">
                <?php if ($module['navigation']) { ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][navigation]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][navigation]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][navigation]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][navigation]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?>
              </td>
              <td class="module_options module_options_no_rborder">
                <?php echo $entry_css3_transitions; ?>
              </td>
              <td class="module_options" colspan="3">
                <?php if ($module['css3_transitions']) { ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][css3_transitions]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][css3_transitions]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][css3_transitions]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][css3_transitions]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?>
              </td>
            </tr>

            <tr>
              <td class="module_options module_options_no_rborder">
                <?php echo $entry_pagination; ?>
              </td>
              <td class="module_options module_options_no_rborder" colspan="2">
                <?php if ($module['pagination']) { ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][pagination]" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][pagination]" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][pagination]" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][pagination]" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?>
              </td>
              <td class="module_options module_options_no_rborder">
                <?php echo $entry_css3_transitions_type; ?>
              </td>
              <td class="module_options" colspan="3">
                <select name="mmr_owl_slideshow_module[<?php echo $module_row; ?>][css3_transitions_type]">
                  <?php foreach ($css3_transitions_types as $option) { ?>
                  <?php ($option ==  $module['css3_transitions_type']) ? $active = 'selected' : $active=''; ?>
                  <option value="<?php echo $option; ?>" <?php echo $active; ?>><?php echo $option; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr><td class="module_options_empty" colspan="7"></td></tr>

          </tbody>
          <?php $module_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="6"></td>
              <td class="left"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="mmr_owl_slideshow_module[' + module_row + '][banner_id]">';
	<?php foreach ($banners as $banner) { ?>
	html += '      <option value="<?php echo $banner['banner_id']; ?>"><?php echo addslashes($banner['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><input type="text" name="mmr_owl_slideshow_module[' + module_row + '][width]" value="" size="3" /> <input type="text" name="mmr_owl_slideshow_module[' + module_row + '][height]" value="" size="3" /></td>';
	html += '    <td class="left"><select name="mmr_owl_slideshow_module[' + module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="mmr_owl_slideshow_module[' + module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="mmr_owl_slideshow_module[' + module_row + '][status]">';
  html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
  html += '      <option value="0"><?php echo $text_disabled; ?></option>';
  html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="mmr_owl_slideshow_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';

  html += '  <tr>';
  html += '    <td class="module_options module_options_no_rborder" rowspan="3"><?php echo $entry_items; ?></td>';
  html += '    <td class="module_options module_options_no_rborder" colspan="2" rowspan="3">';
  html += '    <select name="mmr_owl_slideshow_module[' + module_row + '][items_desktop]">';
  <?php for ($i = 1; $i <= 12; $i++) { ?>
  html += '    <option value="<?php echo $i; ?>" <?php if ($i==1) { ?>selected<?php } ?>><?php echo $i; ?></option>';
  <?php } ?>
  html += '    </select> <span class="help inline"><?php echo $entry_items_desktop; ?></span><br />';
  html += '    <select name="mmr_owl_slideshow_module[' + module_row + '][items_desktop_small]">';
  <?php for ($i = 1; $i <= 12; $i++) { ?>
  html += '    <option value="<?php echo $i; ?>" <?php if ($i==1) { ?>selected<?php } ?>><?php echo $i; ?></option>';
  <?php } ?>
  html += '    </select> <span class="help inline"><?php echo $entry_items_desktop_small; ?></span><br />';
  html += '    <select name="mmr_owl_slideshow_module[' + module_row + '][items_tablet]">';
  <?php for ($i = 1; $i <= 12; $i++) { ?>
  html += '    <option value="<?php echo $i; ?>" <?php if ($i==1) { ?>selected<?php } ?>><?php echo $i; ?></option>';
  <?php } ?>
  html += '    </select> <span class="help inline"><?php echo $entry_items_tablet; ?></span><br />';
  html += '    <select name="mmr_owl_slideshow_module[' + module_row + '][items_tablet_small]">';
  <?php for ($i = 1; $i <= 12; $i++) { ?>
  html += '    <option value="<?php echo $i; ?>" <?php if ($i==1) { ?>selected<?php } ?>><?php echo $i; ?></option>';
  <?php } ?>
  html += '    </select> <span class="help inline"><?php echo $entry_items_tablet_small; ?></span><br />';
  html += '    <select name="mmr_owl_slideshow_module[' + module_row + '][items_mobile]">';
  <?php for ($i = 1; $i <= 12; $i++) { ?>
  html += '    <option value="<?php echo $i; ?>" <?php if ($i==1) { ?>selected<?php } ?>><?php echo $i; ?></option>';
  <?php } ?>
  html += '    </select> <span class="help inline"><?php echo $entry_items_mobile; ?></span><br />';
  html += '    </td>';
  html += '    <td class="module_options module_options_no_rborder"><?php echo $entry_autoplay; ?></td>';
  html += '    <td class="module_options" colspan="3"><input type="radio" name="mmr_owl_slideshow_module[' + module_row + '][autoplay]" value="1" checked="checked" /><?php echo $text_yes; ?><input type="radio" name="mmr_owl_slideshow_module[' + module_row + '][autoplay]" value="0" /><?php echo $text_no; ?></td>';
  html += '  </tr>';

  html += '  <tr>';
  html += '    <td class="module_options module_options_no_rborder"><?php echo $entry_delay; ?></td>';
  html += '    <td class="module_options" colspan="3">';
  html += '    <select name="mmr_owl_slideshow_module[' + module_row + '][delay]">';
  <?php for ($i = 1; $i <= 30; $i++) { ?>
  html += '    <option value="<?php echo $i; ?>" <?php if ($i==7) { ?>selected<?php } ?>><?php echo $i; ?></option>';
  <?php } ?>
  html += '    </select>';
  html += '    </td>';
  html += '  </tr>';

  html += '  <tr>';
  html += '    <td class="module_options module_options_no_rborder"><?php echo $entry_progress; ?></td>';
  html += '    <td class="module_options" colspan="3"><input type="radio" name="mmr_owl_slideshow_module[' + module_row + '][progress]" value="1" checked="checked" /><?php echo $text_yes; ?><input type="radio" name="mmr_owl_slideshow_module[' + module_row + '][progress]" value="0" /><?php echo $text_no; ?></td>';
  html += '  </tr>';

  html += '  <tr>';
  html += '    <td class="module_options module_options_no_rborder"><?php echo $entry_navigation; ?></td>';
  html += '    <td class="module_options module_options_no_rborder" colspan="2"><input type="radio" name="mmr_owl_slideshow_module[' + module_row + '][navigation]" value="1" checked="checked" /><?php echo $text_yes; ?><input type="radio" name="mmr_owl_slideshow_module[' + module_row + '][navigation]" value="0" /><?php echo $text_no; ?></td>';
  html += '    <td class="module_options module_options_no_rborder"><?php echo $entry_css3_transitions; ?></td>';
  html += '    <td class="module_options" colspan="3">';
  html += '    <input type="radio" name="mmr_owl_slideshow_module[' + module_row + '][css3_transitions]" value="1" checked="checked" /><?php echo $text_yes; ?><input type="radio" name="mmr_owl_slideshow_module[' + module_row + '][css3_transitions]" value="0" /><?php echo $text_no; ?>';
  html += '    </td>';
  html += '  </tr>';

  html += '  <tr>';
  html += '    <td class="module_options module_options_no_rborder"><?php echo $entry_pagination; ?></td>';
  html += '    <td class="module_options module_options_no_rborder" colspan="2"><input type="radio" name="mmr_owl_slideshow_module[' + module_row + '][pagination]" value="1" checked="checked" /><?php echo $text_yes; ?><input type="radio" name="mmr_owl_slideshow_module[' + module_row + '][pagination]" value="0" /><?php echo $text_no; ?></td>';
  html += '    <td class="module_options module_options_no_rborder"><?php echo $entry_css3_transitions_type; ?></td>';
  html += '    <td class="module_options" colspan="3">';
  html += '    <select name="mmr_owl_slideshow_module[' + module_row + '][css3_transitions_type]">';
  <?php foreach ($css3_transitions_types as $option) { ?>
  html += '    <option value="<?php echo $option; ?>" <?php if ($option=="fade") { ?>selected<?php } ?>><?php echo $option; ?></option>';
  <?php } ?>
  html += '    </select>';
  html += '    </td>';
  html += '  </tr>';

  html += '  <tr><td class="module_options_empty" colspan="7"></td></tr>';
	html += '</tbody>';

	$('#module tfoot').before(html);
	
	module_row++;
}
//--></script> 
<?php echo $footer; ?>