<?php
    $url = base_url() . 'patient/add_notes/'.$patient_id.'/'.$appointment_id;

    if (isset($notes['id'])) {
        $url .= '/'.$notes['id'];
    }
?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        
        <form method="post" id="add_notes" action="<?php echo $url; ?>">
            <div class="modal-body">
                <div class="tab-container">
                    <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home-2" role="tab" aria-expanded="true">Notes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile-2" role="tab" aria-expanded="false">Diet & Diagnosis</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#messages-2" role="tab" aria-expanded="false">Medicines</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="home-2" role="tabpanel" aria-expanded="true">
                            <div class="col-sm-12">
                                <textarea name="notes" id="notes" class="wysiwyg-editor"><?php echo isset($notes['notes']) ? $notes['notes'] : ""; ?></textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-2" role="tabpanel" aria-expanded="false">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Diet</label>
                                    <textarea class="form-control" name="diet" id="diet"  rows="5" placeholder=""><?php echo isset($notes['diet']) ? $notes['diet'] : ""; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Diagnosis</label>
                                    <textarea class="form-control" name="diagnosis" id="diagnosis"  rows="5" placeholder=""><?php echo isset($notes['diagnosis']) ? $notes['diagnosis'] : ""; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="messages-2" role="tabpanel">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Consulting Amount</label>
                                            <input type="text" class="form-control amount-mask" name="consulting_amount" dir="ltr" value="<?php echo isset($notes['consulting_amount']) ? $notes['consulting_amount'] : ""; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Medicine Amount</label>
                                            <input type="text" class="form-control amount-mask" name="medicine_amount" dir="ltr" value="<?php echo isset($notes['medicine_amount']) ? $notes['medicine_amount'] : ""; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Total Amount</label>
                                            <input type="text" class="form-control amount-mask" name="total_amount" dir="ltr" value="<?php echo isset($notes['amount']) ? $notes['amount'] : ""; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Payment Received</label>
                                            <input type="text" class="form-control amount-mask" name="received_amount" dir="ltr" value="<?php echo isset($notes['received_amount']) ? $notes['received_amount'] : ""; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Balance Amount</label>
                                            <?php 
                                                $balance = 0;
                                                if (isset($notes['received_amount'])) {
                                                    $balance = $notes['amount'] - $notes['received_amount'];
                                                    
                                                    if ($balance > 0) {
                                                        $balance = $balance.' DR';
                                                    } else if ($balance < 0) {
                                                        $balance= substr($balance, 1);
                                                        $balance= $balance.' CR';
                                                    }
                                                }
                                            ?>
                                            <input type="text" class="form-control" name="balace_amount" dir="ltr" value="<?php echo $balance; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Payment Mode</label>
                                            <select name="payment_mode" class="form-control">
                                                <?php foreach($payment_modes as $mode) { ?>
                                                    <option><?php echo $mode->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 extra_payment_box <?php echo (isset($notes['received_amount']) && (($notes['received_amount'] > $notes['amount']))) ? '' : 'hide'; ?>">
                                        <div class="form-group">
                                            <label>Extra Payment Reason</label>
                                            <select name="extra_payment_reason" class="form-control">
                                                <option value="0">Select Reason</option>
                                                <option value="1" <?php echo (isset($notes['extra_payment_reason']) && ($notes['extra_payment_reason'] == 1)) ? 'selected' : ''; ?>>Previous pending payment</option>
                                                <option value="2" <?php echo (isset($notes['extra_payment_reason']) && ($notes['extra_payment_reason'] == 2)) ? 'selected' : ''; ?>>Extra advance payment</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Medicines</label>
                                    <textarea class="form-control" rows="5" name="medicines" id="medicines" placeholder=""><?php echo isset($notes['medicines']) ? $notes['medicines'] : ""; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer modal-footer--bordered">
                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Dismiss</button>
                <button type="submit" class="btn btn-success btn-lg">Update</button>
            </div>
        </form>    
    </div>
</div>