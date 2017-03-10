<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
        <section >
            <form  method="post" >
                
                <table>
                    <caption>Aanpassen van een bestaande cursus</caption>
                    <tr>
                        <td>datum:</td>
                        <td>
                            <input type="text" class="js-datepicker" placeholder="kies verplicht een startdatum" name="datum" required="required" value="<?= !empty($activiteit->getDatum())?$activiteit->getDatum():'';?>">
                        </td>
                    </tr>
                    <tr >
                        <td>tijd:</td>
                        <td>
                            <input type="text" class="js-timepicker" placeholder='kies verplicht een starttijd' name="tijd" required="required" value="<?= !empty($activiteit->getTijd())?$activiteit->getTijd():'';?>" >
                        </td>
                    </tr>
                    <tr>
                        <td>soort:</td>
                        <td>
                            <select name="soort">
                                 <?php foreach($soorten as $soort)
                                 {
                                     if($activiteit->getSoortId()==$soort->getId())
                                     {
                                         echo '<option selected value="'.$soort->getId().'"  >'.$soort->getNaam().'</option>';
                                     }
                                     else
                                     {
                                         echo '<option value="'.$soort->getId().'">'.$soort->getNaam().'</option>';
                                     }
                                     
                                 }
                                     
                                ?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" value="verander">
                            <input type="reset" value="reset"> 
                        </td>
                    </tr>
                   
                </table>
                
            </form>  
        <br >
        </section>
<?php include 'includes/footer.php';