<h1>Contribuer au projet</h1>

<h2>Prérequis</h2>
<p>Si vous ne l'avez pas encore fait, vous devez d'abord configurer Git . N'oubliez pas de configurer également l'authentification à GitHub à partir de Git .</p>

<h2>Installer le projet</h2>

<ul>
<li>Fork le repository sous l'url: "https://github.com/Thibault-OC/P8", avec le bouton fork en haut à droite .</li>
<li>Cloner le projet avec la commande <code>git clone</code></li>
<li>Déplacé vous dans le dossier du projet <code>cd "nomDuProjet"</code></li>
<li>Créer une branche  depuis la branche "main" <code> git branch NomDeLaBranche</code> pour vos modifications</li>
<li>Initier le projet, suivez les intructions du fichier "Readme.md" du projet</li>
</ul>

<h2>Contributions</h2>
<ul>
<li>Ajouter/Modifier une fonctionnalité du projet, assurez-vous de suivre les normes de codage.</li>
<li>Tester le code avec PhpUnit avec la commande suivante <code>php bin/phpunit --coverage-html ./tests/report</code></li>
<li>Poussez votre branche modifiée vers votre fork dans votre compte GitHub : 
    <ul>
        <li>Indexe les modifications qui ont été faites dans les fichiers <code>git add NomDuFichier</code></li>
        <li>Enregirster les modifications avec un commit <code>git commit -m "ma nouvelle fonctionnalité"</code></li>
        <li>Pousser ces modifications sur le repository <code>git push</code></li>
    </ul>
</li>
<li>Créez une pull request pour vos modifications sur le projet</li>
<li>Le pull Request validé rebasez une nouvelle branche sur "main"</li>
</ul>