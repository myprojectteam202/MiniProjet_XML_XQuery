(: ===== INSERTION ===== :)

insert node

<membre id="M009" categorieRef="C2">

    <nom>Zerrouk</nom>
    <prenom>Lyna</prenom>
    <email>lyna@club.dz</email>

</membre>

into doc("club.xml")//membres

(: ===== MODIFICATION ===== :)

replace value of node
doc("club.xml")//concours[@id="CO2"]/@coefficient

with "2.5"



(: ===== SUPPRESSION ===== :)

delete node

doc("club.xml")//concours[@id="CO1"]
//participant[@membreRef="M003"]

