
<table width="100%" align="center" cellpadding="0" cellspacing="0" style="max-width: 560px; margin: auto; border: 1px solid #CACACA;">
    <tr>
        <td bgcolor="" style="">
            <table width="100%" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" style="padding:20px 0px;background-color: #fff;">
                        <h2>Hospital Management System</h2>
                        <p>Doctor name with designation will goes here</p>
                    </td>
                </tr>
                <tr>
                    <td height="10" bgcolor="#CACACA"></td>
                </tr>
                <tr>
                    <td valign="top" bgcolor="" style="padding:20px; ">
                        <table width="100%" cellspacing="0" cellpadding="0" style="">
                            <tr>
                                <td>
                                    <table style="width: 100%;">
                                        <tbody>
                                            <tr>
                                                <td align="left" valign="top" style="font-family: Arial,sans-serif;font-size: 14px;line-height: 22px;">
                                                    <p style="margin: 0;"><strong>Invoice No :</strong>{{isset($invoice['invoice_id']) ? $invoice['invoice_id']: ''}}</p>
                                                </td>
                                                <td align="right" valign="top" style="font-family: Arial,sans-serif;font-size: 14px;line-height: 22px;">
                                                    <p style="margin: 0;"><strong>Date :</strong> {{isset($invoice['appointment_date']) && $invoice['appointment_date'] !="0000-00-00" ? date("d/m/Y", strtotime($invoice['appointment_date'])): ''}}</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <table style="width: 100%;">
                                        <tbody>
                                            <tr>
                                                <td valign="top" style="font-family: Arial,sans-serif;font-size: 14px;line-height: 22px;">
                                                    <p style="margin: 0;"><strong>Name :</strong>{{ ucfirst($invoice['title'])." ".ucfirst($invoice['firstname'])." ".ucfirst($invoice['lastname'])}}</p>
                                                    <p style="margin: 0;"><strong>Phone :</strong> {{isset($invoice['phone']) ? $invoice['phone'] : ''}}</p>
                                                    <p style="margin: 0;"><strong>Address :</strong> {{ isset($invoice['address']) ? $invoice['address'] : ''}} , {{ isset($invoice['city']) ? $invoice['city'] : ''}}-{{isset($invoice['zipcode']) ? $invoice['zipcode'] : ''}}</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="25">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" style="min-width:100%;">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="padding:5px;text-align: left; font-family: Arial,sans-serif;background-color: #e9e9e9; font-size: 14px; line-height:20px;line-height:30px;border: 1px solid #ddd;">Description</th>
                                                <th scope="col" style="padding:5px;text-align: right; font-family: Arial,sans-serif;background-color: #e9e9e9; font-size: 14px; line-height:20px;line-height:30px;border: 1px solid #ddd;">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($invoice['consulting_amount']) && ($invoice['consulting_amount'] != '0.00'))
                                                <tr>
                                                    <td valign="top" style="padding: 15px 5px; font-family: Arial,sans-serif; font-size: 14px; line-height:20px;border: 1px solid #ddd;">Consulting charges</td>
                                                    <td valign="top" style="padding: 15px 5px;text-align: right; font-family: Arial,sans-serif; font-size: 14px; line-height:20px;border: 1px solid #ddd;">{{$invoice['consulting_amount']}} RS</td>
                                                </tr>
                                            @endif
                                            @if (isset($invoice['medicine_amount']) && ($invoice['medicine_amount'] != '0.00'))
                                                <tr>
                                                    <td valign="top" style="padding: 15px 5px; font-family: Arial,sans-serif; font-size: 14px; line-height:20px;border: 1px solid #ddd;">Medicine charges</td>
                                                    <td valign="top" style="padding: 15px 5px; text-align: right; font-family: Arial,sans-serif; font-size: 14px; line-height:20px;border: 1px solid #ddd;">{{$invoice['medicine_amount']}} RS</td>
                                                </tr>
                                            @endif
                                            @if (isset($invoice['amount']) && (isset($invoice['received_amount'])) && (($invoice['received_amount'] - $invoice['amount']) > 0))
                                                <tr>
                                                    <td valign="top" style="padding: 15px 5px; font-family: Arial,sans-serif; font-size: 14px; line-height:20px;border: 1px solid #ddd;">{{isset($invoice['extra_payment_reason']) ? (($invoice['extra_payment_reason'] == 1) ? 'Previous pending payment' : 'Extra advance payment') : 'Extra Payment'}}</td>
                                                    <td valign="top" style="padding: 15px 5px; text-align: right; font-family: Arial,sans-serif; font-size: 14px; line-height:20px;border: 1px solid #ddd;">{{number_format(($invoice['received_amount'] - $invoice['amount']), 2)}} RS</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td valign="top" style="padding: 15px 5px; font-family: Arial,sans-serif; font-size: 18px; background: #fffed3; line-height:20px;border: 1px solid #ddd;">Total Amount</td>
                                                <td valign="top" style="padding: 15px 5px; text-align: right; font-family: Arial,sans-serif; font-size: 18px; background: #fffed3; line-height:20px;border: 1px solid #ddd;">{{(($invoice['received_amount'] - $invoice['amount']) > 0) ? $invoice['received_amount'] : $invoice['amount']}} RS</td>
                                            </tr>
                                            @if (isset($invoice['amount']) && (isset($invoice['received_amount'])) && (($invoice['amount'] - $invoice['received_amount']) > 0))
                                                <tr>
                                                    <td valign="top" style="padding: 15px 5px; font-family: Arial,sans-serif; font-size: 14px; line-height:20px;border: 1px solid #ddd;">Amount Received</td>
                                                    <td valign="top" style="padding: 15px 5px; text-align: right; font-family: Arial,sans-serif; font-size: 14px; line-height:20px;border: 1px solid #ddd;">{{$invoice['received_amount']}} RS</td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" style="padding: 15px 5px; font-family: Arial,sans-serif; font-size: 14px; line-height:20px;border: 1px solid #ddd;">Amount Pending</td>
                                                    <td valign="top" style="padding: 15px 5px; text-align: right; font-family: Arial,sans-serif; font-size: 14px; line-height:20px;border: 1px solid #ddd;">{{$invoice['amount'] - $invoice['received_amount']}} RS</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td height="25" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 15px; padding-left:0px;">Thank you</td>
                            </tr>
                            <tr>
                                <td height="25" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 15px; padding-left:0px;">Have a healthy life</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="10" bgcolor="#CACACA"></td>
                </tr>
                <tr>
                    <td height="10"></td>
                </tr>
                <tr>
                    <td align="center" bgcolor="" background="" style="padding:10px 0px;">
                        <p>ADDRESS : Street Name, Road ABC</p>
                        <p><small>Mobile : 123 456 7890</small></p>
                        <p><small>Website : www.domainname.com</small></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>