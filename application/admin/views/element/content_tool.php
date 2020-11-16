<div id="position" >
<strong>当前位置：</strong>
<a href="javascript:void(0);">网站管理</a>
<?php $patternInfo = $this->advdbclass->getControllerName($table); ?>
<a href="javascript:void(0);"><?php echo $patternInfo['title']; ?></a>
</div>
<br />
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>快捷方式</caption>
  <tbody>
  <tr>
    <td>
    <?php if ($table == 'guestbook') { ?>
    <a href="javascript:void(0);"><span id="<?php echo $table; ?>_save">回复<?php echo $patternInfo['alias']; ?></span></a> |
    <?php } else { ?>
    <a href="admincp.php/<?php echo $table; ?>/save"><span id="<?php echo $table; ?>_save">添加<?php echo $patternInfo['alias']; ?></span></a> |
    <?php } ?>
    <a href="admincp.php/<?php echo $table; ?>/index/1"><span id="<?php echo $table; ?>_"><?php echo $patternInfo['alias']; ?>列表</span></a>
<?php
    $systemInfo = $this->advdbclass->getSystem();
    if ($table != 'job' && $table != 'link' && $table != 'guestbook' && $table != 'ask' && $systemInfo['html']) { ?>
    |
    <a href="admincp.php/<?php echo $table; ?>/html"><span id="<?php echo $table; ?>_html">更新html</span></a>
    <?php } ?>
    </td>
  </tr>
</tbody>
</table>