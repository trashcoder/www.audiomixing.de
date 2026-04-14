<?php declare(strict_types=1); ?>
<!doctype html>
<html>

<head>
    <title>audiomixing.de - Real Panning</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/mainstyle.css">
</head>

<body>
    <?php require_once("../header.php"); ?>

    <article class="product-detail">

        <h1>Real Panning</h1>

        <div class="product-detail-image-placeholder">
            <!-- Bild hier einfügen: <img src="../images/real_panning.png" alt="Real Panning Screenshot" class="fullscreen_image"> -->
            <span class="product-detail-image-label">[ Screenshot folgt ]</span>
        </div>

        <section class="product-detail-description">
            <h2>Was ist Real Panning?</h2>
            <p>
                Real Panning ist ein Audio-Plugin, das Stereo-Panning auf physikalisch korrekte Weise umsetzt.
                Statt eines einfachen Lautstärke-Splits zwischen links und rechts simuliert Real Panning
                die natürliche Wahrnehmung von Schallquellen im Raum — basierend auf Laufzeitunterschieden
                (ITD) und Pegeldifferenzen (ILD) zwischen beiden Ohren.
            </p>

            <h2>Warum Real Panning?</h2>
            <p>
                Klassische Pan-Regler in DAWs verschieben ein Signal nur durch Lautstärkeunterschiede.
                Das klingt in der Mitte des Lautsprecher-Setups überzeugend, verliert aber schnell an
                Natürlichkeit, sobald ein Signal weit links oder rechts positioniert wird. Real Panning
                löst dieses Problem mit zwei dedizierten Reglern — Panning und Latenz — die gemeinsam
                die natürliche Schallwahrnehmung des menschlichen Gehörs nachbilden.
            </p>

            <h2>Features</h2>
            <ul>
                <li>Zwei Regler: <strong>Panning</strong> für die Stereoposition, <strong>Latenz</strong> für die Laufzeitverzögerung</li>
                <li>Physikalisch korrekte Laufzeitdifferenz (ITD) zwischen L und R</li>
                <li>Pegelbasierte Differenzierung (ILD) für realistische Tiefenstaffelung</li>
                <li>VST3 — kompatibel mit allen gängigen DAWs</li>
                <li>Verfügbar für Windows, Mac und Linux</li>
            </ul>

            <h2>Status</h2>
            <p>
                Real Panning befindet sich aktuell in der Beta-Phase und kann bereits
                <a href="../downloads.php">heruntergeladen</a> werden.
            </p>
        </section>

    </article>

    <?php require_once("../footer.php"); ?>
</body>

</html>
