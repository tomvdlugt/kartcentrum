<?php 
include 'includes/header.php';
include 'includes/menu.php';?>
        <section >
             <table> 
                 <caption>
                        Dit zijn alle beschikbare activiteiten
                 </caption>
                <thead>
                    <tr>
                        <td>datum</td>
                        <td>tijd</td>
                        <td>soort Activiteit</td>
                        <td>prijs</td>
                        <td>Schrijf in</td>                       
                    </tr>
                </thead>
                <tbody>
                <?php foreach($beschikbare_activiteiten as $activiteit):?>
                    <tr>
                        <td>
                            <?= $activiteit->getDatum();?></td>
                        </td>
                        <td>
                            <?= $activiteit->getTijd();?>
                        </td>
                        
                        <td>
                            <?= $activiteit->getSoort();?>
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            <?= "&euro;".number_format($activiteit->getPrijs(),2,',','.');?>
                        </td>
                         <td title="schrijf in voor activiteit">
                             <a href='?control=deelnemer&action=adddeelname&id=<?= $activiteit->getId();?>'><img src="img/toevoegen.png">
                             </a>
                         </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            </br>
              <table >
                <caption>
                      Dit zijn de door jou ingeschreven activiteiten
                </caption>
                <thead>
                     <tr>
                        <td>datum</td>
                        <td>tijd</td>
                        <td>soort Activiteit</td>
                        <td>prijs</td>
                        <td>Schrijf uit</td>                       
                    </tr>
                </thead>
                <tbody>
                <?php foreach($ingeschreven_activiteiten as $activiteit):?>
                    <tr>
                         <td>
                            <?= $activiteit->getDatum();?></td>
                        </td>
                        <td>
                            <?= $activiteit->getTijd();?>
                        </td>
                        
                        <td>
                            <?= $activiteit->getSoort();?>
                        </td>
                        <td>
                            <?= "&euro;".number_format($activiteit->getPrijs(),2,',','.');?>
                        </td>
                         <td title="verwijder cursus">
                             <a href='?control=deelnemer&action=deletedeelname&id=<?= $activiteit->getId();?>'><img src="img/verwijder.png">
                             </a>
                         </td>
                    </tr>
                <?php endforeach;?>
                    <tr>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                            Totaal prijs:
                        </td>
                        <td>
                            <?php $totaal=0;
                                  foreach($ingeschreven_activiteiten as $activiteit)
                                  {
                                    $totaal+=$activiteit->getPrijs();
                                  }
                                  echo "&euro;".number_format($totaal,2,',','.');
                            
                            ?>
                        </td>
                        <td>
                    </tr>
                
                </tbody>
            </table>
            
            <br  />
        </section>
<?php include 'includes/footer.php';