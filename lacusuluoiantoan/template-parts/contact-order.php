<div class="pd-btn">
    <button class="seopressbtn" style="cursor: pointer;" data-toggle="modal" data-target="#order-call">
      Mua hàng
    </button>
</div>
<!-- Modal -->
<div id="order-call" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Liên hệ đặt hàng</h4>
      </div>
      <div class="modal-body">
        <?php echo get_theme_mod("lacusu_order_contact", '<span>Vui lòng gọi </span><a href="tel:0901463986">0901463986</a><span> hoặc </span><a href="tel:0948855439">0948855439</a>')?>
	      <!-- <span>Vui lòng gọi </span>
	      <a href="tel:0901463986">0901463986</a>
	      <span> hoặc </span>
	      <a href="tel:0948855439">0948855439</a> -->
        <!-- <p>Hotline 0901463986 - 0948855439</p> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
      </div>
    </div>

  </div>
</div>