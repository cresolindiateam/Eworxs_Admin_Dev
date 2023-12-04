<div class="modal fade" id="upgrad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Upgrade Plan</h4>
      </div>
      <form  method="post" id="paymentForm">
       <div class="modal-body">
        <!-- choose upgrading plan  -->
        <input type="hidden"  name="updateplan" value="">
         <input type="hidden"  name="currentplanid" value="<?php echo $get_current_plan ; ?>">
         <p>Select your plan:</p>
            <?php if($get_current_plan==41){?>
              <input type="radio" id="selfpaid" name="fav_language" value="price_1LsiyAG2OgVatMfqwWQ3xYR8">
              <label for="selfpaid">self paid </label><br>
              <input type="radio" id="selfpaidyear" name="fav_language" value="price_1Lsiz5G2OgVatMfq464KRuO3">
              <label for="selfpaidyear">Self employed/year</label><br>
              <input type="radio" id="businessmonthly" name="fav_language" value="price_1Lsj1BG2OgVatMfqUq1Jfo1E">
              <label for="businessmonthly">Teams Premium/worker/monthly</label>
              <input type="radio" id="businessyearly" name="fav_language" value="price_1Lsj1eG2OgVatMfq1y2rBOrQ">
              <label for="businessyearly">Teams Premium/worker/year</label><br>
              <input type="radio" id="businessacemonthly" name="fav_language" value="price_1KuFddG2OgVatMfqbIO6HJsd">
              <label for="businessacemonthly">Teams Ace/worker/monthly</label>
              <input type="radio" id="businessaceyearly" name="fav_language" value="price_1LsMoGG2OgVatMfqfBMN8OVW">
            <label for="businessaceyearly">Teams Ace/worker/year</label>
              <?php }?>
            <?php if($get_current_plan==42){?>
                <input type="radio" id="selfpaidyear" name="fav_language" value="price_1Lsiz5G2OgVatMfq464KRuO3">
                <label for="selfpaidyear">Self employed/year</label><br>
                <input type="radio" id="businessmonthly" name="fav_language" value="price_1Lsj1BG2OgVatMfqUq1Jfo1E">
                <label for="businessmonthly">Teams Premium/worker/monthly</label>
                <input type="radio" id="businessyearly" name="fav_language" value="price_1Lsj1eG2OgVatMfq1y2rBOrQ">
                <label for="businessyearly">Teams Premium/worker/year</label><br>
               <input type="radio" id="businessacemonthly" name="fav_language" value="price_1KuFddG2OgVatMfqbIO6HJsd">
              <label for="businessacemonthly">Teams Ace/worker/monthly</label>
             <input type="radio" id="businessaceyearly" name="fav_language" value="price_1LsMoGG2OgVatMfqfBMN8OVW">
             <label for="businessaceyearly">Teams Ace/worker/year</label>

            <?php }?>

                <?php if($get_current_plan==43){?>
                  <input type="radio" id="businessmonthly" name="fav_language" value="price_1Lsj1BG2OgVatMfqUq1Jfo1E">
                 <label for="businessmonthly">Teams Premium/worker/monthly</label>
            <input type="radio" id="businessyearly" name="fav_language" value="price_1Lsj1eG2OgVatMfq1y2rBOrQ">
            <label for="businessyearly">Teams Premium/worker/year</label><br>
           <input type="radio" id="businessacemonthly" name="fav_language" value="price_1KuFddG2OgVatMfqbIO6HJsd">
            <label for="businessacemonthly">Teams Ace/worker/monthly</label>
          <input type="radio" id="businessaceyearly" name="fav_language" value="price_1LsMoGG2OgVatMfqfBMN8OVW">
            <label for="businessaceyearly">Teams Ace/worker/year</label>

            
            <?php }?>


             <?php if($get_current_plan==44){?>
                  
           <input type="radio" id="businessacemonthly" name="fav_language" value="price_1KuFddG2OgVatMfqbIO6HJsd">
            <label for="businessacemonthly">Teams Ace/worker/monthly</label>
          <input type="radio" id="businessaceyearly" name="fav_language" value="price_1LsMoGG2OgVatMfqfBMN8OVW">
            <label for="businessaceyearly">Teams Ace/worker/year</label>

            
            <?php }?>


 <?php if($get_current_plan==71){?>
                  
         
          <input type="radio" id="businessaceyearly" name="fav_language" value="price_1LsMoGG2OgVatMfqfBMN8OVW">
            <label for="businessaceyearly">Teams Ace/worker/year</label>

            
            <?php }?>

           <?php if($get_current_plan==40){?>
             <input type="radio" id="businessyearly" name="fav_language" value="price_1Lsj1eG2OgVatMfq1y2rBOrQ">
            <label for="businessyearly">Teams Premium/worker/year</label>
              <input type="radio" id="businessacemonthly" name="fav_language" value="price_1KuFddG2OgVatMfqbIO6HJsd">
                  <label for="businessacemonthly">Teams Ace/worker/monthly</label>
          <input type="radio" id="businessaceyearly" name="fav_language" value="price_1LsMoGG2OgVatMfqfBMN8OVW">
            <label for="businessaceyearly">Teams Ace/worker/year</label>
           <?php }?>
           <br/>
            <p style="font-weight: bold;">Amount: $<span id="total_charge">0.00</span> 
             <input type="hidden" id="total_charge_default" value=""/></p>
           <div id="worker_section">
             <label for="no_of_workers">No. Of Workers </label>
             <input type="number" class="form-control" required value="" id="no_of_workers" name="noofworkers" placeholder="No Of Worker">
          </div>
             <br/><br/>
              <div>card details</div>
              <label for="card_number">Card Number </label>
            <input type="text" id="card_number" placeholder="Card Number" name="card_number" value="" class="form-control">
              <br>
             <label for="expiry_month">Expiry Month</label>
            <input type="text" placeholder="Expiry Month" id="expiry_month" name="expiry_month" value="" class="form-control">
            <br>
            <label for="expiry_year">Expiry Year</label>
            <input type="text" placeholder="Expiry Year" id="expiry_year" name="expiry_year" value="" class="form-control">
          
           <br>
           <label for="businessyearly">CVV</label>
           <input type="text" placeholder="CVC"  id="cvv" name="cvc" value="" class="form-control">
      </div>
      <div class="modal-footer">
        <input type="button"  id="updateplan" name="updateplan" class="btn theme-btn" value="upgrade current plan">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
      </div>
    </div>
  </div>  
</div>
