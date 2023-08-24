<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="INDEX.css">
<title>Activité</title>
<style>
    body {
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: white;
        flex-direction: column;
    }
    #drapeau {
        display: flex;
        width: 300px;
        height: 200px;
        margin: 20px 0;
    }
    .bande {
        flex: 1;
    }
    .vert {
        background-color: green;
    }
    .jaune {
        background-color: yellow;
        position: relative;
    }
    #etoile {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: green;
        font-size: 24px;
    }
    .rouge {
        background-color: red;
    }
    #paroles {
        max-width: 800px;
        margin: 20px auto;
        text-align: center;
        line-height: 1.5;
    }
</style>
</head>
<body>
<div id="drapeau">
    <div class="bande vert"></div>
    <div class="bande jaune">
        <div id="etoile">&#9733;</div>
    </div>
    <div class="bande rouge"></div>
</div>
<div id="paroles">
    <p>Pincez tous vos koras, frappez les balafons.<br>
    Le lion rouge a rugi.<br>
    Le dompteur de la brousse<br>
    D'un bond s'est élancé,<br>
    Dissipant les ténèbres.<br>
    Soleil sur nos terreurs, soleil sur notre espoir.<br>
    Debout, frères, voici l'Afrique rassemblée.</p>
    <p>Fibres de mon cœur vert.<br>
    Épaule contre épaule, mes plus que frères,<br>
    Ô Sénégalais, debout !<br>
    Unissons la mer et les sources, unissons la steppe et la forêt !<br>
    Salut Afrique mère.</p>
</div>
<h2>Le Drapeau Du Sénégal et son Hymne National</h2>
</body>
</html>
