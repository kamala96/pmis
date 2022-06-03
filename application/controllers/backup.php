 if ($weight > 10) {
        
    $weight10    = 10;
    $getPrice    = $this->organization_model->get_zone_country_price10($zone,$weight10,$emstype);

    //$vat10       = $getPrice->vat;
    //$price10     = $getPrice->tariff_price;
    $totalprice10 = $getPrice->zone_price;
    $diff   =  $weight - $weight10;

    if ($emstype == "Document") {

    if ($diff <= 0.5) {

        if ($zone == 'ZONE1') {
            $totalPrice = $totalprice10 + 4000;
        }if ($zone == 'ZONE2') {
            $totalPrice = $totalprice10 + 6100;
        }if ($zone == 'ZONE3') {
            $totalPrice = $totalprice10 + 7300;
        }if ($zone == 'ZONE4') {
            $totalPrice = $totalprice10 + 7600;
        }if ($zone == 'ZONE5') {
            $totalPrice = $totalprice10 + 8400;
        }if ($zone == 'ZONE6') {
            $totalPrice = $totalprice10 + 9800;
        }

        $dvat = $totalPrice * 0.18;
        $dprice = $totalPrice - ($totalPrice * 0.18);
        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$dprice' class='price1'></td></tr>
            </table>";


    } else {

            $whole   = floor($diff);
            $decimal = fmod($diff,1);
            if ($decimal == 0) {

                if ($zone == 'ZONE1') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*4000;
                }if ($zone == 'ZONE2') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*6100;
                }if ($zone == 'ZONE3') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*7300;
                }if ($zone == 'ZONE4') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*7600;
                }if ($zone == 'ZONE5') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*8400;
                }if ($zone == 'ZONE6') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*9800;
                }
                

            } else {

                if ($decimal <= 0.5) {

                    
                    if ($zone == 'ZONE1') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*4000 + 4000;
                    }if ($zone == 'ZONE2') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*6100 + 6100;
                    }if ($zone == 'ZONE3') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*7300 + 7300;
                    }if ($zone == 'ZONE4') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*7600 + 7600;
                    }if ($zone == 'ZONE5') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*8400 + 8400;
                    }if ($zone == 'ZONE6') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9800 + 9800;
                    }

                } else {

                    
                    if ($zone == 'ZONE1') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*4000 + 4000 + 4000;
                    }if ($zone == 'ZONE2') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*6100 + 6100 + 6100;
                    }if ($zone == 'ZONE3') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*7300 + 7300 + 7300;
                    }if ($zone == 'ZONE4') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*7600 + 7600 + 7600;
                    }if ($zone == 'ZONE5') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*8400 + 8400 + 8400;
                    }if ($zone == 'ZONE6') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9800 + 9800 + 9800;
                    }
                }

            }
            $dvat = $totalPrice * 0.18;
         $dprice = $totalPrice - ($totalPrice * 0.18);
            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$dprice' class='price1'></td></tr>
            </table>";
    }

    } else {

    if ($diff <= 0.5) {

        if ($zone == 'ZONE1') {
            $totalPrice = $totalprice10 + 5100;
        }if ($zone == 'ZONE2') {
            $totalPrice = $totalprice10 + 6900;
        }if ($zone == 'ZONE3') {
            $totalPrice = $totalprice10 + 9000;
        }if ($zone == 'ZONE4') {
            $totalPrice = $totalprice10 + 9100;
        }if ($zone == 'ZONE5') {
            $totalPrice = $totalprice10 + 9900;
        }if ($zone == 'ZONE6') {
            $totalPrice = $totalprice10 + 11000;
        }

        $dvat = $totalPrice * 0.18;
        $dprice = $totalPrice - ($totalPrice * 0.18);
        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$dprice' class='price1'></td></tr>
            </table>";


    } else {

            $whole   = floor($diff);
            $decimal = fmod($diff,1);
            if ($decimal == 0) {

                if ($zone == 'ZONE1') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*5100;
                }if ($zone == 'ZONE2') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*6900;
                }if ($zone == 'ZONE3') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*9000;
                }if ($zone == 'ZONE4') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*9100;
                }if ($zone == 'ZONE5') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*9900;
                }if ($zone == 'ZONE6') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*11000;
                }
                

            } else {

                if ($decimal <= 0.5) {

                    
                    if ($zone == 'ZONE1') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*5100 + 5100;
                    }if ($zone == 'ZONE2') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*6900 + 6900;
                    }if ($zone == 'ZONE3') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9000 + 9000;
                    }if ($zone == 'ZONE4') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9100 + 9100;
                    }if ($zone == 'ZONE5') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9900 + 9900;
                    }if ($zone == 'ZONE6') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*11000 + 11000;
                    }

                } else {

                    
                    if ($zone == 'ZONE1') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*5100 + 5100 + 5100;
                    }if ($zone == 'ZONE2') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*6900 + 6900 + 6900;
                    }if ($zone == 'ZONE3') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9000 + 9000 + 9000;
                    }if ($zone == 'ZONE4') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9100 + 9100 + 9100;
                    }if ($zone == 'ZONE5') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9900 + 9900 + 9900;
                    }if ($zone == 'ZONE6') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*11000 + 11000 + 11000;
                    }
                }

            }

            $dvat = $totalPrice * 0.18;
            $dprice = $totalPrice - ($totalPrice * 0.18);
            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$dprice' class='price1'></td></tr>
            </table>";
    }
    }
    
    


    } else {
        
        $Getprice = $this->organization_model->get_zone_country_price($zone,$weight,$emstype);

        if (empty($Getprice)) {

            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Price:</b></td><td>0</td></tr>
            <tr><td><b>Vat:</b></td><td>0</td></tr>
            <tr><td><b>Total Price:</b></td><td>0</td></tr>
            </table>";

        }else{

            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Price:</b></td><td><input type='text' name ='price1' value='$Getprice->zone_tariff' class='price1'></td></tr>
            <tr><td><b>Vat:</b></td><td><input type='text' name ='vat' value='$Getprice->zone_vat' class='price1'></td></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$Getprice->zone_price' class='price1'></td></tr>
            </table>";

        }

    }
