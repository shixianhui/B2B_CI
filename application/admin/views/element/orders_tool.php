<div id="position" >
<strong>当前位置：</strong>
<a href="javascript:void(0);">订单管理 </a>
<a href="javascript:void(0);">订单列表</a>
</div>
<br />
<table class="table_form" cellpadding="0" cellspacing="1">
  <caption>快捷方式</caption>
  <tbody>
  <tr>
    <td>
    <a href="admincp.php/orders/index/all/-1"><span id="orders_index_all">所有订单列表</span></a>
    <a href="admincp.php/orders/index/0/-1"><span id="orders_index_0">未付款</span></a>
    <a href="admincp.php/orders/index/1/-1"><span id="orders_index_1">已付款</span></a>
    <a href="admincp.php/orders/index/2/-1"><span id="orders_index_2">已发货</span></a>
    <a href="admincp.php/orders/index/3/-1"><span id="orders_index_3">交易成功</span></a>
    <a href="admincp.php/orders/index/4/-1"><span id="orders_index_4">交易关闭</span></a>
    </td>
  </tr>
</tbody>
</table>
<script type="text/javascript">
    $(document).ready(function() {
        var uri = "<?php echo $this->uri->segment(3); ?>";
        if (uri) {
            $('#orders_index_' + uri + '').addClass('toolColor');
        }
    });
</script>