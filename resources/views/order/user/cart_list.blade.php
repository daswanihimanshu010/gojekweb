 <div class="modal-dialog dis-center">
   <div class="modal-content min-70vw">
      <!-- Cart Header -->
      <div class="modal-header">
         <h4 class="modal-title">Cart</h4>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Cart body -->
      <div class="modal-body">
         <!-- Empty Cart -->
         <div class="widget widget-cart empty-cart d-none">
            <div class="widget-heading bg-white b-0 p-0 dis-column">
               <div class="clearfix"></div>
               <img class="w-50 mt-3" src="../img/foody/empty-cart.svg">
            </div>
         </div>
         <!-- Empty Cart -->
         <div class="row m-0">
            <div class="widget-body col-sm-12 col-md-12 col-xl-6 height60vh" id="rcart_list">
               loading.......................
            </div>
            <div class="cart-totals-fields col-sm-12 col-md-12 col-xl-6">
               <table class="table">
                  <tbody>
                     <tr>
                        <td>Cart Subtotal</td>
                        <td><span class="tot_gross right"></span></td>
                     </tr>
                     <tr class="d-none">
                        <td>Shop Offer</td>
                        <td><span class="shop_offer right"></span></td>
                     </tr>
                     <tr>
                        <td>Shop GST</td>
                        <td><span class="shop_gst right"></span></td>
                     </tr>
                      <tr>
                        <td>Shop Package Charge</td>
                        <td><span class="shop_pkg right"></span></td>
                     </tr>
                     <tr class="d-none">
                        <td>Promocode</td>
                        <td><span class="promocode right"></span></td>
                     </tr>
                     <tr>
                        <td class="others d-none" >Shipping &amp; Handling</td>
                        <td class="food d-none">Delivery Charge</td>
                        <td class="delivery_charge right">$2.00</td>
                     </tr>
                  </tbody>
               </table>
               <div class="widget-body green">
                  <div class="price-wrap text-center">
                     <i class="material-icons address-category">attach_money</i>
                     <p class="txt-white">GRAND TOTAL</p>
                     <h3 class="value txt-white"><strong class="Total">$ 25,49</strong></h3>
                     <p class="txt-white freeship">Free Shipping</p>
                     <!-- <a id="checkout" href="./checkout.php" class="btn btn-primary bg-white primary-color">Checkout <i class="fa fa-arrow-right" aria-hidden="true"></i></a> -->
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Cart footer -->
      <div class="modal-footer">
         <a  class="btn btn-primary chk_url" href="{{url('user/store/checkout/')}}">Checkout <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
      </div>
   </div>
</div>



<script type="text/javascript">
	function forceNumeric(){
    var $input = $(this);
    $input.val($input.val().replace(/[^\d]+/g,''));
    }
    $('body').on('propertychange input', '.qty_prod', forceNumeric);
loadcart();
function  loadcart(){
	$.ajax({
         url: getBaseUrl() + "/user/store/cartlist",
         type:"GET",
         processData: false,
         contentType: false,
         secure: false,
         headers: {
             Authorization: "Bearer " + getToken("user")
         },
         success: (data, textStatus, jqXHR) => {
            if((data.responseData).length != 0) { 
               var cart_list = data.responseData;
               $('.cart_tot').html((cart_list.carts).length);
               var cartlist ='';
               $('.chk_url').attr('href',"{{url('user/store/checkout/')}}/"+cart_list.store_id);
              if(cart_list.store_type=='FOOD'){
                $('.food').removeClass('d-none');
                $('.others').addClass('d-none');
              }else{
                $('.food').addClass('d-none');
                $('.others').removeClass('d-none');
              }
               
               $.each(cart_list.carts, function(i,val){
                cartlist +='<ul class="list-inline w-100 order-row dis-space-btw">\
                    <li class="list-inline-item">\
                       <h5 class="price ">'+val.product.item_name+'</h5>\
                       <p class="txt-color1 m-0">'+currency+val.product.item_price+'</p>';
                    if((val.cartaddon).length>0){
                     cartlist +='<a class="text-color c-pointer item-with-addon"  data-id="'+val.store_item_id+'"  data-spid="111" >Customize <i class="fa fa-cogs" aria-hidden="true"></i></a>';
                 	}
                    cartlist +='</li>\
                    <li class="list-inline-item quantity ">\
                       <span class="add  eminus"  data-id="'+val.store_item_id+'"  data-cat_id="'+val.id+'"  value="-" id="moins" >-</span>\
                       <input class="form-control text-center qty_prod_'+val.store_item_id+'" min="1" readonly type="input" size="25" value="'+val.quantity+'" id="count_'+val.store_item_id+'">\
                       <span class="minus  eplus" data-id="'+val.store_item_id+'" data-cat_id="'+val.id+'"  value="+"  id="plus" >+</span>\
                    </li>\
                    <li class="list-inline-item mr-3">\
                       <h5 class="price "></h5>\
                    </li>\
                    <li class="list-inline-item "><a class="cart-el-remove" data-cart_id="'+val.id+'" href="javascript:void(0)"><i class="fa fa-times-circle font-16 primary-color c-pointer"></i></a> </li>\
                 </ul>';
               });
               var show_gross = currency+cart_list.total_price.toFixed(2);
               var show_offer = currency+cart_list.shop_discount.toFixed(2);
               var show_gst = currency+cart_list.shop_gst_amount.toFixed(2);
               var show_delivery = currency+cart_list.delivery_charges;
               var show_total = currency+cart_list.payable.toFixed(2);
               $('#rcart_list').html(cartlist);
               $('.tot_gross').html(show_gross);
               $('.shop_offer').html(show_offer);
               $('.shop_gst').html(show_gst);
               $('.shop_pkg').html(currency+cart_list.shop_package_charge);
               $('.promocode').html(currency+cart_list.promocode_amount);
               $('.Total').html(show_total);
               $('.delivery_charge').html(show_delivery);
               if(cart_list.shop_discount>0){
               	$('.shop_offer').parent('tr').removeClass('d-none');
               	$('.shop_offer').html(currency+cart_list.shop_discount);
               }
               if(cart_list.delivery_charges>0){
               	$('.freeship').addClass('d-none')
               }

            }

         }
        });
}
$('body').on('click','.eplus',function(e){
	var prod_id = $(this).data('id');
	var cart_id = $(this).data('cat_id');
	var elm = $(this).prev(".qty_prod_"+prod_id);
	var qty = elm.val(); 
	$(".qty_prod_"+prod_id).val(parseInt(qty)+1);
   var qty = elm.val();
   $("#add_on_qty").val(qty);
	addcart(prod_id,cart_id,qty,'bplus');
   loadcart();
   return false;
});
$('body').on('click','.eminus',function(e){
	var prod_id = $(this).data('id');
	var cart_id = $(this).data('cat_id');
	var elm = $(this).next(".qty_prod_"+prod_id);
   var qty = elm.val();
	if(qty>1){
      $(".qty_prod_"+prod_id).val(parseInt(qty)-1);
      var qty = elm.val();
      $("#add_on_qty").val(qty);
      addcart(prod_id,cart_id,qty,'bminus');
      loadcart();
	}
   return false;
});

$('body').on('click','.cart-el-remove',function(e){
	var cart_id = $(this).data('cart_id'); 
	removecart(cart_id);
	
});

function removecart(cart_id){
    var data = new FormData();
    data.append( 'cart_id', cart_id );
    $.ajax({
     url: getBaseUrl() + "/user/store/removecart",
     type:"POST",
     processData: false,
     contentType: false,
     secure: false,
     data:data,
     headers: {
         Authorization: "Bearer " + getToken("user")
     },
     success: (data, textStatus, jqXHR) => {
     loadcart();
     shopdetails();

       }
    })
}
</script>