<style>
    .member_table .info{
        width: auto;
    }
</style>
<div class="member_right mt20">

  <div class="box_shadow clearfix m_border">
     <div class="member_title"><span class="bt">评价产品</span></div>


     <table width="100%" border="0" cellspacing="0" cellpadding="0" class="member_table mt20">
  <tbody>
  <tr>
    <th width="5%"><strong>评价</strong></th>
    <th class="tal" width="40%"><strong>评论</strong></th>
    <th class="tal" width="30%"><strong>晒照</strong></th>
    <th class="tal" width="25%"><strong>商品</strong></th>

    </tr>
  <?php if ($comment_list){
      foreach ($comment_list as $key=>$comment) {?>
  <tr>
    <td align="center">
        <div class="flower">
            <?php if ($comment['evaluate'] == 1){ ?>
                <label><span class="red">好评</span></label>
            <?php }elseif($comment['evaluate'] == 2){ ?>
                <label><span class="yellow">中评</span></label>
            <?php }else{ ?>
                <label><span>差评</span></label>
            <?php } ?>
        </div>
    </td>
    <td align="left"><div class="info"><?php if ($comment['content']) { echo str_replace(array("\r\n", "\n", "\r"), '<br/>', $comment['content']);}else{ echo "此用户未填写评论";} ?></div></td>
    <td align="left"><div class="info">
            <?php if($comment['attachment_list']){
                foreach ($comment['attachment_list'] as $value){
            ?>
                    <a data-lightbox="image_list_group_<?php echo $key; ?>" data-title="" href="<?php echo $value['path']; ?>" style="padding-right: 3px;"><img src="<?php echo preg_replace('/\./', '_thumb.', $value['path']); ?>" width="60px" height="60px"></a>
            <?php }} ?>
        </div></td>
    <td align="left"><div class="info"><a href="<?php echo getBaseUrl($html, "", "product/detail/{$comment['product_id']}.html", $client_index); ?>" ><img src="<?php echo preg_replace('/\./', '_thumb.', $comment['path']); ?>"><?php echo $comment['product_title']; ?><p class="c9"></p></a></div></td>

  </tr>
<?php }} ?>
  </tbody>
</table>
      <div class="clear"></div>
      <div class="pagination">
          <ul>
              <?php echo $pagination; ?>
          </ul>
      </div>
   </div>
 </div>

<link rel="stylesheet" href="js/admin/lightbox2-master/src/css/lightbox.css">
<script src="js/admin/lightbox2-master/src/js/lightbox.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 300,
        'wrapAround': true,
        'positionFromTop': 200,
        showImageNumberLabel: false
    });
</script>