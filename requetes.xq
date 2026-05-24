(: ================= Q1 ================= :)

<listeMembres>
{
for $m in doc("club.xml")//membre

let $cat :=
doc("club.xml")//categorie[@id = $m/@categorieRef]

return

<membre id="{$m/@id}">
    <nomComplet>
        {concat($m/prenom," ",$m/nom)}
    </nomComplet>

    <email>{$m/email/text()}</email>

    <categorie>
        {$cat/@libelle/string()}
    </categorie>

</membre>

}
</listeMembres>



(: ================= Q2 ================= :)

for $c in doc("club.xml")//concours/concours

let $cat :=
doc("club.xml")//categorie[@id = $c/@categorieRef]

order by $c/@date

return

<concours>
    <titre>{$c/titre/text()}</titre>
    <date>{$c/@date}</date>
    <coefficient>{$c/@coefficient}</coefficient>
    <categorie>{$cat/@libelle/string()}</categorie>
</concours>



(: ================= Q3 ================= :)

for $c in doc("club.xml")//concours/concours

return

<resultat>

<titre>{$c/titre/text()}</titre>

{
for $p in $c/participants/participant

let $m :=
doc("club.xml")//membre[@id = $p/@membreRef]

let $score :=
($p/complexite + $p/tempsExecution)
* $c/@coefficient

return

<participant>

    <nom>
        {concat($m/prenom," ",$m/nom)}
    </nom>

    <score>
        {round-half-to-even($score,2)}
    </score>

</participant>

}

</resultat>



(: ================= Q4 ================= :)

for $c in doc("club.xml")//concours/concours

let $scores :=

for $p in $c/participants/participant

return

($p/complexite + $p/tempsExecution)
* $c/@coefficient

let $max := max($scores)

return

<vainqueur>

<titre>{$c/titre/text()}</titre>

{

for $p in $c/participants/participant

let $score :=
($p/complexite + $p/tempsExecution)
* $c/@coefficient

where $score = $max

let $m :=
doc("club.xml")//membre[@id = $p/@membreRef]

return

<gagnant>
    <nom>{concat($m/prenom," ",$m/nom)}</nom>
    <score>{$score}</score>
</gagnant>

}

</vainqueur>



(: ================= Q5 ================= :)

declare variable $categorie := "Intelligence Artificielle";

for $m in doc("club.xml")//membre

let $cat :=
doc("club.xml")//categorie[@id=$m/@categorieRef]

where $cat/@libelle = $categorie

order by $m/nom, $m/prenom

return

<membre>
    <nom>{$m/nom/text()}</nom>
    <prenom>{$m/prenom/text()}</prenom>
</membre>