<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
        <section >
            <form  method="post"  > 
                
                <table>
                    <caption>Toevoegen van een nieuwe activiteit</caption>
                    
                        <td>datum:</td>
                        <td>
                            <input type="text" class="js-datepicker" placeholder="dd-mm-yyyy" name="datum"  required="required" value="<?= !empty($form_data['datum'])?$form_data['datum']:'';?>">
                        </td>
                    </tr>
                    <tr >
                        <td>tijd:</td>
                        <td>
                            <input type="text" class="js-timepicker" placeholder='hh:mm' name="tijd" required="required" value="<?= !empty($form_data['tijd'])?$form_data['tijd']:'';?>" >
                        </td>
                    </tr>
                    <tr> 
                        <td>soort:</td>
                        <td>
                            <select name="soort">
                                 <?php foreach($soorten as $soort)
                                 {
                                     echo '<option value="'.$soort->getId().'">'.$soort->getNaam().'</option>';
                                 }
                                     
                                ?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" value="voeg toe">
                            <input type="reset" value="reset"> 
                        </td>
                    </tr>
                   
                </table>
                    
            </form> 
            <br >
        </section>
<?php include 'includes/footer.php';

