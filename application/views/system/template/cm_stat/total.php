<?php
 $this->load->view_system('public/header');?>
</head>
<body>
<table border="0" align="center" cellpadding="0" cellspacing="10" class="forum1" style="width:100%;">
<tbody><tr><td>

<?php
 $this->load->view_system('template/'.$dbtable.'/nav');?>

<?php
 if(!empty($online_shu) && !empty($online_cnt)){?>
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
  <tr class="forumRow2"><td align="center" valign="top">   
    
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
    <tr class="forumRaw">
      <td colspan="2" align="center"> <strong>访问量概况 </strong></td>
      </tr>
    <tr class="forumRow">
      <td align="right">开始统计：</td>
      <td align="center"><?php
 echo $online_cnt->startday;?></td>
      </tr>
    <tr class="forumRow">
      <td align="right">统计天数：</td>
      <td align="center"><?php
 echo $online_cnt->countday;?></td>
      </tr>
    <tr class="forumRow">
      <td align="right">当前在线：</td>
      <td align="center"><?php
 echo $this->sitecount->online(10);?></td>
      </tr>
    <tr class="forumRow">
      <td align="right">最高在线人数：</td>
      <td align="center"><?php
 echo $online_shu->shugo;?></td>
      </tr>
    <tr class="forumRow">
      <td align="right">每日平均：</td>
      <td align="center"><?php
 echo @round($online_cnt->totalpv/$online_cnt->countday);?></td>
      </tr>
    </table>
    
  </td>
  <td align="center">

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="forum2">
                   <tr class="forumRaw">
                     <td>&nbsp;</td>
                     <td align="center"><strong>PV</strong></td>
                     <td align="center"><strong>IP</strong></td>
                     <td align="center"><strong>人均浏览次数</strong></td>
          </tr>
                   <tr class="forumRow">
                     <td align="right">今日：</td>
                     <td align="center"><?php
 echo $online_shu->shupv;?></td>
                     <td align="center"><?php
 echo $online_shu->shuip;?></td>
                     <td align="center"><?php
 echo @round($online_shu->shupv/$online_shu->shuip);?></td>
                   </tr>
                   <tr class="forumRow">
                     <td align="right">昨日：</td>
                     <td align="center"><?php
 echo $online_cnt->yesdaypv;?></td>
                     <td align="center"><?php
 echo $online_cnt->totalip;?></td>
                     <td align="center"><?php
 echo @round($online_cnt->yesdaypv/$online_cnt->totalip);?></td>
                   </tr>
                    <tr class="forumRow">
                      <td align="right">前日：</td>
                      <td align="center"><?php
 echo $online_cnt->day2pv;?></td>
                      <td align="center"><?php
 echo $online_cnt->day2ip;?></td>
                      <td align="center"><?php
 echo @round($online_cnt->day2pv/$online_cnt->day2ip);?></td>
                    </tr>
                    <tr class="forumRow">
                      <td align="right">总计：</td>
                      <td align="center"><?php
 echo $online_cnt->totalpv;?></td>
                      <td align="center"><?php
 echo $online_cnt->totalip;?></td>
                      <td align="center"><?php
 echo @round($online_cnt->totalpv/$online_cnt->totalip);?></td>
                    </tr>
                    <tr class="forumRow">
                      <td align="right">每日平均：</td>
                      <td align="center"><?php
 echo @round($online_cnt->totalpv/$online_cnt->countday);?></td>
                      <td align="center"><?php
 echo @round($online_cnt->totalip/$online_cnt->countday);?></td>
                      <td align="center">&nbsp;</td>
                    </tr>
                    <tr class="forumRow">
                      <td colspan="4" style="padding:12px;">注意：<br>
                        1、当前在线人数，今日IP，今日PV为即时更新数据。<br>
                      2、其他所有数据，每天凌晨只更新一次；目的：节省系统资源，使程序更快执行。</td>
                    </tr>
        </table>
  
  </td></tr>
</table>


<?php
 }?>

</td></tr></tbody></table>
</BODY></HTML>
