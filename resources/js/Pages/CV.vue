<script setup></script>
<template>
    <Head>
        <title>CV</title>
    </Head>
    <div id="cv">
        <div class="border right"></div>
        <div class="border left"></div>
        <div class="border top"></div>
        <div class="border bottom"></div>
        <Link class="return" href="/">Retour à l'accueil - Home</Link>
        <main>
            <h1>Antoine Thériault</h1>

            <h2>
                <a href="http://www.antoinetheriault.com/"
                    >antoinetheriault.com</a
                >
            </h2>

            <h2>theriault.antoine@gmail.com</h2>

            <h2>514 812-4533</h2>

            <h3>Éducation</h3>

            <p>BFA – Studio Arts – Concordia University, QC [2013 – 2017]</p>

            <p>
                Certificat – Arts Visuels – Université Laval, QC [2012 – 2013]
            </p>

            <p>
                DEC – Technique en Intégration Multimédia – CÉGEP Sainte-Foy, QC
                [2008 – 2011]
            </p>

            <h3>Expositions</h3>

            <p>
                Interfold, Issue #12 : Intercept – Launch @ Skol Centre en Art
                Actuel, [April 28th 2017]
            </p>

            <p>
                Écho Boomer&nbsp;: Natifs Numériques – Digital Natives – Projet
                Casa (Dans le cadre Pictura 2020), [26 Novembre – 20 Décembre
                2020]
            </p>

            <p>
                Vagues – Exposition Carte Blanche présentée par Galerie Galerie
                dans le cadre de FIFA 2021 [16 – 28 Mars 2021]
            </p>

            <p>Parfum Liquide – Galerie Galerie [13 Mai – 20 Juin 2021]</p>

            <h3>Publications</h3>

            <p>
                Interfold, Issue #12 : Intercept, FASA Concordia [2017] p.40-41
            </p>

            <h3>Projets Web</h3>

            <p>
                <a
                    rel="noreferrer noopener"
                    aria-label="Visite Virtuelle  (opens in a new tab)"
                    href="http://antoinetheriault.com/peintures.html"
                    target="_blank"
                    >Visite Virtuelle </a
                >– Application Web 3D [2017]
            </p>

            <p>
                <a href="http://antoinetheriault.com/vente/"
                    >Kiosque du Marchand de Peinture</a
                >
                +
                <a href="http://antoinetheriault.com/vente/lumiere/">Lumière </a
                >– Diptyque Web [2019 – 2020]
            </p>

            <p>
                <a href="http://antoinetheriault.com/caroussel/"
                    >Caroussel de Peintures 2020</a
                >
                – Application Web 3D [2021]
            </p>
        </main>
    </div>
</template>
<style lang="scss">
@font-face {
    font-family: "UnifrakturMaguntia";
    font-style: normal;
    font-weight: 400;
    src: url(https://fonts.gstatic.com/s/unifrakturmaguntia/v11/WWXPlieVYwiGNomYU-ciRLRvEmK7oaVemGZM.woff2)
        format("woff2");
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA,
        U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212,
        U+2215, U+FEFF, U+FFFD;
}

#cv {
    font-family: "UnifrakturMaguntia";
    background-image: url("Assets/images/cv/drapo_small.png");
    background-position: right top;
    background-repeat: no-repeat;
    padding: 20px 35px 20px 35px;

    background-color: white;

    color: black;

    h1 {
        font-size: 2.7rem;
        font-weight: bold;
        margin: 15px 0px 40px 0px;
        text-align: left;
    }

    a,
    a:visited {
        color: red;
        text-decoration: none;
    }

    a:hover {
        color: black;
    }

    h2,
    h1,
    p,
    h3 {
        background-color: white;
    }

    h2 {
        font-weight: bold;
        font-style: italic;
        font-size: 1.5rem;
        line-height: 1.8rem;
    }

    h3 {
        font-size: 1.5em;
        margin-bottom: 15px;
        padding-top: 50px;
    }

    p {
        margin: 0px 0px 5px 10px;
        line-height: 1.1rem;
        //float: left;
        //clear: both;

        &:hover {
            font-family: "Times New Roman", serif;
        }
    }

    .infos {
        display: block;
        margin: 0px 0px 50px 15px;
        float: left;
        clear: both;
    }

    .return {
        position: fixed;
        top: 40px;
        right: 40px;
        font-size: 1.5rem;
        font-weight: bold;

        z-index: 5;
    }

    ::selection {
        background: red; /* WebKit/Blink Browsers */
    }
    ::-moz-selection {
        background: red; /* Gecko Browsers */
    }

    .border {
        display: block;
        position: fixed;
        background-color: transparent;
        z-index: 1;

        &.top {
            height: 8px;
            top: 0px;
            left: 0px;
            background-image: url("Assets/images/cv/border-top.gif");
            background-repeat: repeat-x;
            width: 100%;
        }

        &.bottom {
            height: 5px;
            left: 0px;
            bottom: 0px;
            background-image: url("Assets/images/cv/border-bottom.gif");
            background-repeat: repeat-x;
            width: 100%;
        }

        &.left {
            width: 7px;
            left: 0px;
            top: 0px;
            background-image: url("Assets/images/cv/border-left.gif");
            background-repeat: repeat-y;
            height: 100%;
        }

        &.right {
            width: 7px;
            right: 0px;
            top: 0px;
            background-image: url("Assets/images/cv/border-right.gif");
            background-repeat: repeat-y;
            height: 100%;
        }
    }
}
</style>
