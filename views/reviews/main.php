<?php
/**
 * Created by PhpStorm.
 * User: villa
 * Date: 17.10.2018
 * Time: 9:07
 */ ?>
    <div class="content">
        <div class="row">
            <div class="col-md-9">
                <?php foreach($reviews as $review) {?>
                    <div class="row">
                        <div class="col-md-3"><img src="<?=$review->img_main?>" alt=""></div>
                        <div class="col-md-6">
                            <div class="stars_wrapper" >
                                <div class="stars"><?=$review->rank?> stars</div>
                            </div>
                            <br>
                            <a href="?r=reviews&link=<?=$review->link?>" title="">
                                <?=$review->title_en?>
                            </a>
                            <b><?=$review->cost?></b>
                            <?php if($review->recommend_status) { ?>
                                123<img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMS4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ3OC4yIDQ3OC4yIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA0NzguMiA0NzguMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSIxNnB4IiBoZWlnaHQ9IjE2cHgiPgo8Zz4KCTxwYXRoIGQ9Ik00NTcuNTc1LDMyNS4xYzkuOC0xMi41LDE0LjUtMjUuOSwxMy45LTM5LjdjLTAuNi0xNS4yLTcuNC0yNy4xLTEzLTM0LjRjNi41LTE2LjIsOS00MS43LTEyLjctNjEuNSAgIGMtMTUuOS0xNC41LTQyLjktMjEtODAuMy0xOS4yYy0yNi4zLDEuMi00OC4zLDYuMS00OS4yLDYuM2gtMC4xYy01LDAuOS0xMC4zLDItMTUuNywzLjJjLTAuNC02LjQsMC43LTIyLjMsMTIuNS01OC4xICAgYzE0LTQyLjYsMTMuMi03NS4yLTIuNi05N2MtMTYuNi0yMi45LTQzLjEtMjQuNy01MC45LTI0LjdjLTcuNSwwLTE0LjQsMy4xLTE5LjMsOC44Yy0xMS4xLDEyLjktOS44LDM2LjctOC40LDQ3LjcgICBjLTEzLjIsMzUuNC01MC4yLDEyMi4yLTgxLjUsMTQ2LjNjLTAuNiwwLjQtMS4xLDAuOS0xLjYsMS40Yy05LjIsOS43LTE1LjQsMjAuMi0xOS42LDI5LjRjLTUuOS0zLjItMTIuNi01LTE5LjgtNWgtNjEgICBjLTIzLDAtNDEuNiwxOC43LTQxLjYsNDEuNnYxNjIuNWMwLDIzLDE4LjcsNDEuNiw0MS42LDQxLjZoNjFjOC45LDAsMTcuMi0yLjgsMjQtNy42bDIzLjUsMi44YzMuNiwwLjUsNjcuNiw4LjYsMTMzLjMsNy4zICAgYzExLjksMC45LDIzLjEsMS40LDMzLjUsMS40YzE3LjksMCwzMy41LTEuNCw0Ni41LTQuMmMzMC42LTYuNSw1MS41LTE5LjUsNjIuMS0zOC42YzguMS0xNC42LDguMS0yOS4xLDYuOC0zOC4zICAgYzE5LjktMTgsMjMuNC0zNy45LDIyLjctNTEuOUM0NjEuMjc1LDMzNy4xLDQ1OS40NzUsMzMwLjIsNDU3LjU3NSwzMjUuMXogTTQ4LjI3NSw0NDcuM2MtOC4xLDAtMTQuNi02LjYtMTQuNi0xNC42VjI3MC4xICAgYzAtOC4xLDYuNi0xNC42LDE0LjYtMTQuNmg2MWM4LjEsMCwxNC42LDYuNiwxNC42LDE0LjZ2MTYyLjVjMCw4LjEtNi42LDE0LjYtMTQuNiwxNC42aC02MVY0NDcuM3ogTTQzMS45NzUsMzEzLjQgICBjLTQuMiw0LjQtNSwxMS4xLTEuOCwxNi4zYzAsMC4xLDQuMSw3LjEsNC42LDE2LjdjMC43LDEzLjEtNS42LDI0LjctMTguOCwzNC42Yy00LjcsMy42LTYuNiw5LjgtNC42LDE1LjRjMCwwLjEsNC4zLDEzLjMtMi43LDI1LjggICBjLTYuNywxMi0yMS42LDIwLjYtNDQuMiwyNS40Yy0xOC4xLDMuOS00Mi43LDQuNi03Mi45LDIuMmMtMC40LDAtMC45LDAtMS40LDBjLTY0LjMsMS40LTEyOS4zLTctMTMwLTcuMWgtMC4xbC0xMC4xLTEuMiAgIGMwLjYtMi44LDAuOS01LjgsMC45LTguOFYyNzAuMWMwLTQuMy0wLjctOC41LTEuOS0xMi40YzEuOC02LjcsNi44LTIxLjYsMTguNi0zNC4zYzQ0LjktMzUuNiw4OC44LTE1NS43LDkwLjctMTYwLjkgICBjMC44LTIuMSwxLTQuNCwwLjYtNi43Yy0xLjctMTEuMi0xLjEtMjQuOSwxLjMtMjljNS4zLDAuMSwxOS42LDEuNiwyOC4yLDEzLjVjMTAuMiwxNC4xLDkuOCwzOS4zLTEuMiw3Mi43ICAgYy0xNi44LDUwLjktMTguMiw3Ny43LTQuOSw4OS41YzYuNiw1LjksMTUuNCw2LjIsMjEuOCwzLjljNi4xLTEuNCwxMS45LTIuNiwxNy40LTMuNWMwLjQtMC4xLDAuOS0wLjIsMS4zLTAuMyAgIGMzMC43LTYuNyw4NS43LTEwLjgsMTA0LjgsNi42YzE2LjIsMTQuOCw0LjcsMzQuNCwzLjQsMzYuNWMtMy43LDUuNi0yLjYsMTIuOSwyLjQsMTcuNGMwLjEsMC4xLDEwLjYsMTAsMTEuMSwyMy4zICAgQzQ0NC44NzUsMjk1LjMsNDQwLjY3NSwzMDQuNCw0MzEuOTc1LDMxMy40eiIgZmlsbD0iIzAwMDAwMCIvPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" />
                            <?php } else { ?>
                                <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMS4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ3OC4xNzQgNDc4LjE3NCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDc4LjE3NCA0NzguMTc0OyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjE2cHgiIGhlaWdodD0iMTZweCI+CjxnPgoJPHBhdGggZD0iTTQ1Ny41MjUsMTUzLjA3NGMxLjktNS4xLDMuNy0xMiw0LjItMjBjMC43LTE0LjEtMi44LTMzLjktMjIuNy01MS45YzEuMy05LjIsMS4zLTIzLjgtNi44LTM4LjMgICBjLTEwLjctMTkuMi0zMS42LTMyLjItNjIuMi0zOC43Yy0yMC41LTQuNC00Ny40LTUuMy04MC0yLjhjLTY1LjctMS4zLTEyOS43LDYuOC0xMzMuMyw3LjNsLTIzLjUsMi44Yy02LjgtNC44LTE1LjEtNy42LTI0LTcuNmgtNjEgICBjLTIzLDAtNDEuNiwxOC43LTQxLjYsNDEuNnYxNjIuNWMwLDIzLDE4LjcsNDEuNiw0MS42LDQxLjZoNjFjNy4yLDAsMTMuOS0xLjgsMTkuOC01YzQuMiw5LjIsMTAuNCwxOS43LDE5LjYsMjkuNCAgIGMwLjUsMC41LDEsMSwxLjYsMS40YzMxLjQsMjQuMSw2OC40LDExMC45LDgxLjUsMTQ2LjNjLTEuMywxMS0yLjYsMzQuOCw4LjQsNDcuN2M0LjksNS43LDExLjcsOC44LDE5LjMsOC44ICAgYzcuNywwLDM0LjMtMS44LDUwLjktMjQuN2MxNS43LTIxLjgsMTYuNi01NC40LDIuNi05N2MtMTEuOC0zNS44LTEyLjktNTEuNy0xMi41LTU4LjFjNS40LDEuMiwxMC43LDIuMywxNS44LDMuMmgwLjEgICBjMC45LDAuMiwyMi45LDUuMSw0OS4yLDYuM2MzNy40LDEuOCw2NC41LTQuNyw4MC4zLTE5LjJjMjEuOC0xOS45LDE5LjItNDUuMywxMi43LTYxLjVjNS42LTcuMywxMi40LTE5LjIsMTMtMzQuNCAgIEM0NzEuOTI1LDE3OC45NzQsNDY3LjMyNSwxNjUuNjc0LDQ1Ny41MjUsMTUzLjA3NHogTTEwOS4yMjUsMjIyLjY3NGgtNjFjLTguMSwwLTE0LjYtNi42LTE0LjYtMTQuNnYtMTYyLjUgICBjMC04LjEsNi42LTE0LjYsMTQuNi0xNC42aDYxYzguMSwwLDE0LjYsNi42LDE0LjYsMTQuNnYxNjIuNUMxMjMuODI1LDIxNi4xNzQsMTE3LjMyNSwyMjIuNjc0LDEwOS4yMjUsMjIyLjY3NHogTTQzMC45MjUsMjMyLjM3NCAgIGMwLDAuMSwzLjUsNS42LDQuNywxMy4xYzEuNSw5LjMtMS4xLDE3LTguMSwyMy40Yy0xOS4xLDE3LjQtNzQuMSwxMy40LTEwNC44LDYuNmMtMC40LTAuMS0wLjgtMC4yLTEuMy0wLjMgICBjLTUuNS0xLTExLjQtMi4yLTE3LjQtMy41Yy02LjQtMi4zLTE1LjItMi0yMS44LDMuOWMtMTMuMywxMS44LTExLjgsMzguNiw0LjksODkuNWMxMSwzMy40LDExLjQsNTguNiwxLjIsNzIuNyAgIGMtOC42LDExLjktMjIuOCwxMy40LTI4LjIsMTMuNWMtMi40LTQtMy4xLTE3LjctMS4zLTI5YzAuMy0yLjIsMC4xLTQuNS0wLjYtNi43Yy0xLjktNS4xLTQ1LjgtMTI1LjMtOTAuNy0xNjAuOSAgIGMtMTEuNy0xMi43LTE2LjgtMjcuNi0xOC42LTM0LjNjMS4yLTMuOSwxLjktOC4xLDEuOS0xMi40di0xNjIuNGMwLTMtMC4zLTYtMC45LTguOGwxMC4xLTEuMmgwLjFjMC42LTAuMSw2NS43LTguNSwxMzAtNy4xICAgYzAuNCwwLDAuOSwwLDEuNCwwYzMwLjMtMi40LDU0LjgtMS43LDcyLjksMi4yYzIyLjQsNC44LDM3LjIsMTMuMiw0NCwyNS4xYzcuMSwxMi4zLDMuMiwyNSwyLjksMjYuMmMtMi4xLDUuNi0wLjIsMTEuNyw0LjYsMTUuMyAgIGMyOS42LDIyLjIsMTYsNDguMSwxNC4yLDUxLjNjLTMuMyw1LjItMi41LDExLjgsMS44LDE2LjNjOC42LDksMTIuOCwxOCwxMi41LDI2LjhjLTAuNCwxMy4xLTEwLjUsMjIuOS0xMS4yLDIzLjUgICBDNDI4LjIyNSwyMTkuNDc0LDQyNy4zMjUsMjI2Ljc3NCw0MzAuOTI1LDIzMi4zNzR6IiBmaWxsPSIjMDAwMDAwIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />
                            <?php } ?>
                        </div>
                        <div class="col-md-3">
                            Added: <b><?=date("H:m d.m.Y",strtotime($review->create_date))?></b>
                            <br>
                            USER ID: <b><?=$review->user_id?></b>
                        </div>
                    </div>
                    <br>
                    <hr>
                <?php } ?>
            </div>
            <div class="col-md-3" style="min-height:500px;color:#fff; background: #003333;border:1px solid #ccc">
                Right block
            </div>
        </div>

    </div>