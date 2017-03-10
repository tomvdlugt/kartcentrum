<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
        <section >
            <form  method="post"> 
                
                <table>
                    <caption>Toevoegen van een nieuwe deelnemer</caption>
                    <tr>
                        <td>gebuikersnaam:</td>
                        <td>
                            <input type="text" placeholder="kies verplicht een gebuikersnaam" name="gn" required="required" value="<?= !empty($form_data['gn'])?$form_data['gn']:'';?>">
                        </td>
                    </tr>
                    <tr >
                        <td>wachtwoord:</td>
                        <td>
                            <input type="text" name="ww" placeholder='kies eventueel een ww default "qwerty"' value="<?= !empty($form_data['ww'])?$form_data['ww']:'';?>" >
                        </td>
                    </tr>
                    <tr>
                        <td>voorletter</td>
                        <td>
                            <input type="text" name="vl" placeholder="vul verplicht de voorletter in" required="required" value="<?= !empty($form_data['vl'])?$form_data['vl']:'';?>" >
                        </td>
                    </tr>
                    <tr>
                        <td>tussenvoegsel:</td>
                        <td><input type="text" name="tv" placeholder="vul eventueel tussenvoegsels in" value="<?= !empty($form_data['tv'])?$form_data['tv']:'';?>" >
                        </td>
                    </tr>
                    <tr>
                        <td>achternaam:</td>
                        <td><input type="text" name="an" placeholder="vul verplicht de achternaam in" required="required" value="<?= !empty($form_data['an'])?$form_data['an']:'';?>"> 
                        </td>
                    </tr>
                    <tr>
                        <td>adres:</td>
                        <td><input type="text" name="adres" placeholder="vul verplicht adres in" required="required" value="<?= !empty($form_data['adres'])?$form_data['adres']:'';?>"> 
                        </td>
                    </tr>
                    <tr>
                        <td>postcode:</td>
                        <td><input type="text" name="pc" placeholder="vul verplicht adres in" required="required" value="<?= !empty($form_data['pc'])?$form_data['pc']:'';?>"> 
                        </td>
                    </tr>
                    <tr>
                        <td>woonplaats:</td>
                        <td><input type="text" name="plaats" placeholder="vul verplicht adres in" required="required" value="<?= !empty($form_data['plaats'])?$form_data['plaats']:'';?>"> 
                        </td>
                    </tr>
                    <tr>
                        <td>email:</td>
                        <td>
                            <input type="email" name="email" placeholder="geef verplicht een email op" required="required" value="<?= !empty($form_data['email'])?$form_data['email']:'';?>">
                        </td>
                    </tr>
                   
                    <tr>
                        <td>telefoon:</td>
                        <td>
                            <input type="text" name="tel" placeholder="vul eventueel een intern nummer in" value="<?= !empty($form_data['tel'])?$form_data['tel']:'';?>" />
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

