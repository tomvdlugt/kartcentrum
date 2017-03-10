<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
        <section >
            
                
                <form  method="post" autocomplete="off">   
                    <table>
                        <caption>Inloggen</caption>    
                        <tr>
                            <td>gebruikersnaam:</td>
                            <td>
                                <input type="text" autocomplete="off" placeholder="vul uw gebuikersnaam in" name="gn" value='<?= isset($gn)?$gn:"";?>' required="required" />
                            </td>
                        </tr>
                        <tr >
                           <td>wachtwoord:</td>
                           <td>
                                <input type="password" autocomplete="off" name="ww" placeholder="vul uw wachtwoord in" required="required" />
                           </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" value="inloggen"><input type="reset" value="reset" />
                            </td>
                        </tr>
                    </table>
                </form>
           
        </section>
<?php include 'includes/footer.php';