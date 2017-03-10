<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
    <section >
        <table >
            <caption>Dit zijn alle activiteiten van het kartcentrum</caption>
            <thead>
                <tr>
                    <td>Datum</td>
                    <td>Tijd</td>
                    <td>Soort Activiteit</td>
                    <td>Deelnemers</td>
                    <td colspan="2">acties</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($activiteiten as $activiteit):?>
                <tr>
                    
                    <td><?= $activiteit->getDatum();?></td>
                    <td> <?= $activiteit->getTijd();?></td>
                    <td><?= $activiteit->getSoort();?></td>
                    <td><?= $activiteit->getAantal();?></td>
                    
                    <td title="deelnemers van deze activiteit"><a href='?control=medewerker&action=details&id=<?= $activiteit->getId();?>'><img src="img/details.png"></a></td>
                   
                </tr>
                <?php endforeach;?>
               
            </tbody>
        </table>
        <br />
    </section>
<?php include 'includes/footer.php';