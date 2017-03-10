<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
    <section >
        <table >
            <caption>Dit zijn alle activiteiten van het kartcentrum</caption>
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Naam</td>
                    <td>minimale leeftijd</td>
                    <td>tijdsduur activiteit</td>
                    <td>Prijs</td>
                    <td colspan="2">acties</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($soortActiviteiten as $soortActiviteit):?>
                <tr>
                    
                    <td><?= $soortActiviteit->getId();?></td>
                    <td><?= $soortActiviteit->getNaam();?></td>
                    <td><?= $soortActiviteit->getMin_leeftijd();?></td>
                    <td><?= $soortActiviteit->getTijdsduur();?></td>
                    <td><?= $soortActiviteit->getPrijs();?></td>
                    <td title="bewerk de gegevens van deze activiteit"><a href='?control=medewerker&action=update&id=<?= $soortActiviteit->getId();?>'><img src="img/bewerk.png"></a></td>
                    <td title="verwijder deze activiteit is definitief"><a href='?control=medewerker&action=delete&id=<?= $soortActiviteit->getId();?>'><img src="img/verwijder.png"></a></td>
                </tr>
                <?php endforeach;?>
                <tr>
                    <td>
                        <a href='?control=medewerker&action=add'>
                            <figure>
                                <img src="img/toevoegen.png" alt='voeg een activiteit toe' title='voeg een activiteit toe' />
                            </figure>
                        </a>
                    </td>
                    <td colspan='8'>Voeg een activiteit toe</td>
                </tr>
            </tbody>
        </table>
        <br />
    </section>
<?php include 'includes/footer.php';