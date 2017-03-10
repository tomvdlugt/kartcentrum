<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
    <section >
        <table>
                        <caption>Activiteit</caption>    
                        <tr>
                            <td>datum:</td>
                            <td><?= $activiteit->getDatum();?></td>
                        </tr>
                        <tr >
                           <td>tijd:</td>
                           <td><?= $activiteit->getTijd();?></td>
                        </tr>
                         <tr >
                           <td>naam:</td>
                           <td><?= $activiteit->getSoort();?></td>
                        </tr>
                        
        </table>
        <?php if(count($deelnemers)>0):?>
        <table>
            <caption>Dit zijn de deelnemers</caption>
            <thead>
                <tr>
                    <td>naam</td>
                    <td>adres</td>
                    <td>postcode</td>
                    <td>woonplaats</td>
                    <td>email</td>
                    <td>telefoon</td>
                    
                   
                </tr>
            </thead>
            <tbody>
                <?php foreach($deelnemers as $deelnemer):?>
                <tr>
                    
                    <td><?= $deelnemer->getNaam();?></td>
                    <td> <?= $deelnemer->getAdres();?></td>
                    <td> <?= $deelnemer->getPostcode();?></td>
                    <td><?= $deelnemer->getWoonplaats();?></td>
                    <td><?= $deelnemer->getEmail();?></td>
                    <td><?= $deelnemer->getTelefoon();?></td>
                   
                </tr>
                <?php endforeach;?>
                
            </tbody>
        </table>
        <?php else:?>
        <p> geen deelnemers </p>
        <?php endif;?>
        
        <br  />
    </section>
<?php include 'includes/footer.php';

