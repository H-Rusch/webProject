<?php

include_once "./DAO/config.php";
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Datenschutzverordnung</title>
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png">
    <?php
    include_once "./includes/klaro.php";
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1"/>
</head>

<body>
<!--- Header navigation include-->
<?php
include "./includes/nav.php";
?>
<main>
    <section class="standard-text">
        <h1>Cookie Einstellungen</h1>
        <P>Ihre Cookies können Sie <a href="#" onclick="klaro.show(); return false;">hier</a> verwalten.</P>

        <h1>Datenschutzerklärung</h1>
        <h2 id="m14">Einleitung</h2>
        <p>Mit der folgenden Datenschutzerklärung möchten wir Sie darüber aufklären, welche Arten Ihrer
            personenbezogenen Daten (nachfolgend auch kurz als "Daten“ bezeichnet) wir zu welchen Zwecken und in welchem
            Umfang verarbeiten. Die Datenschutzerklärung gilt für alle von uns durchgeführten Verarbeitungen
            personenbezogener Daten, sowohl im Rahmen der Erbringung unserer Leistungen als auch insbesondere auf
            unseren Webseiten, in mobilen Applikationen sowie innerhalb externer Onlinepräsenzen, wie z.B. unserer
            Social-Media-Profile (nachfolgend zusammenfassend bezeichnet als "Onlineangebot“).</p>
        <p>Die verwendeten Begriffe sind nicht geschlechtsspezifisch.</p>
        <p>Stand: 4. Juli 2021</p>
        <h2>Inhaltsübersicht</h2>
        <ul class="index">
            <li><a class="index-link" href="#m14">Einleitung</a></li>
            <li><a class="index-link" href="#m3">Verantwortlicher</a></li>
            <li><a class="index-link" href="#mOverview">Übersicht der Verarbeitungen</a></li>
            <li><a class="index-link" href="#m13">Maßgebliche Rechtsgrundlagen</a></li>
            <li><a class="index-link" href="#m12">Löschung von Daten</a></li>
            <li><a class="index-link" href="#m134">Einsatz von Cookies</a></li>
            <li><a class="index-link" href="#m367">Registrierung, Anmeldung und Nutzerkonto</a></li>
            <li><a class="index-link" href="#m432">Community Funktionen</a></li>
            <li><a class="index-link" href="#m328">Plugins und eingebettete Funktionen sowie Inhalte</a></li>
            <li><a class="index-link" href="#m15">Änderung und Aktualisierung der Datenschutzerklärung</a></li>
            <li><a class="index-link" href="#m10">Rechte der betroffenen Personen</a></li>
            <li><a class="index-link" href="#m42">Begriffsdefinitionen</a></li>
        </ul>
        <h2 id="m3">Verantwortlicher</h2>
        <p>Erika Mustermann<br>Hauptstraße 1<br>12345 Musterstadt Deutschland</p>
        <p>E-Mail-Adresse: muster@mail.de.</p>
        <h2 id="mOverview">Übersicht der Verarbeitungen</h2>
        <p>Die nachfolgende Übersicht fasst die Arten der verarbeiteten Daten und die Zwecke ihrer Verarbeitung zusammen
            und verweist auf die betroffenen Personen.</p>
        <h3>Arten der verarbeiteten Daten</h3>
        <ul>
            <li>Bestandsdaten (z.B. Namen, Adressen).</li>
            <li>Inhaltsdaten (z.B. Eingaben in Onlineformularen).</li>
            <li>Kontaktdaten (z.B. E-Mail, Telefonnummern).</li>
            <li>Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</li>
            <li>Nutzungsdaten (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten).</li>
        </ul>
        <h3>Kategorien betroffener Personen</h3>
        <ul>
            <li>Kommunikationspartner.</li>
            <li>Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</li>
        </ul>
        <h3>Zwecke der Verarbeitung</h3>
        <ul>
            <li>Bereitstellung unseres Onlineangebotes und Nutzerfreundlichkeit.</li>
            <li>Direktmarketing (z.B. per E-Mail oder postalisch).</li>
            <li>Marketing.</li>
            <li>Kontaktanfragen und Kommunikation.</li>
            <li>Profile mit nutzerbezogenen Informationen (Erstellen von Nutzerprofilen).</li>
            <li>Sicherheitsmaßnahmen.</li>
            <li>Erbringung vertraglicher Leistungen und Kundenservice.</li>
            <li>Verwaltung und Beantwortung von Anfragen.</li>
        </ul>
        <h3 id="m13">Maßgebliche Rechtsgrundlagen</h3>
        <p>Im Folgenden erhalten Sie eine Übersicht der Rechtsgrundlagen der DSGVO, auf deren Basis wir personenbezogene
            Daten verarbeiten. Bitte nehmen Sie zur Kenntnis, dass neben den Regelungen der DSGVO nationale
            Datenschutzvorgaben in Ihrem bzw. unserem Wohn- oder Sitzland gelten können. Sollten ferner im Einzelfall
            speziellere Rechtsgrundlagen maßgeblich sein, teilen wir Ihnen diese in der Datenschutzerklärung mit.</p>
        <ul>
            <li><strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a. DSGVO)</strong> - Die betroffene Person hat ihre
                Einwilligung in die Verarbeitung der sie betreffenden personenbezogenen Daten für einen spezifischen
                Zweck oder mehrere bestimmte Zwecke gegeben.
            </li>
            <li><strong>Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b. DSGVO)</strong> - Die
                Verarbeitung ist für die Erfüllung eines Vertrags, dessen Vertragspartei die betroffene Person ist, oder
                zur Durchführung vorvertraglicher Maßnahmen erforderlich, die auf Anfrage der betroffenen Person
                erfolgen.
            </li>
            <li><strong>Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO)</strong> - Die Verarbeitung ist zur
                Wahrung der berechtigten Interessen des Verantwortlichen oder eines Dritten erforderlich, sofern nicht
                die Interessen oder Grundrechte und Grundfreiheiten der betroffenen Person, die den Schutz
                personenbezogener Daten erfordern, überwiegen.
            </li>
        </ul>
        <p><strong>Nationale Datenschutzregelungen in Deutschland</strong>: Zusätzlich zu den Datenschutzregelungen der
            Datenschutz-Grundverordnung gelten nationale Regelungen zum Datenschutz in Deutschland. Hierzu gehört
            insbesondere das Gesetz zum Schutz vor Missbrauch personenbezogener Daten bei der Datenverarbeitung
            (Bundesdatenschutzgesetz – BDSG). Das BDSG enthält insbesondere Spezialregelungen zum Recht auf Auskunft,
            zum Recht auf Löschung, zum Widerspruchsrecht, zur Verarbeitung besonderer Kategorien personenbezogener
            Daten, zur Verarbeitung für andere Zwecke und zur Übermittlung sowie automatisierten Entscheidungsfindung im
            Einzelfall einschließlich Profiling. Des Weiteren regelt es die Datenverarbeitung für Zwecke des
            Beschäftigungsverhältnisses (§ 26 BDSG), insbesondere im Hinblick auf die Begründung, Durchführung oder
            Beendigung von Beschäftigungsverhältnissen sowie die Einwilligung von Beschäftigten. Ferner können
            Landesdatenschutzgesetze der einzelnen Bundesländer zur Anwendung gelangen.</p>
        <h2 id="m12">Löschung von Daten</h2>
        <p>Die von uns verarbeiteten Daten werden nach Maßgabe der gesetzlichen Vorgaben gelöscht, sobald deren zur
            Verarbeitung erlaubten Einwilligungen widerrufen werden oder sonstige Erlaubnisse entfallen (z.B. wenn der
            Zweck der Verarbeitung dieser Daten entfallen ist oder sie für den Zweck nicht erforderlich sind).</p>
        <p>Sofern die Daten nicht gelöscht werden, weil sie für andere und gesetzlich zulässige Zwecke erforderlich
            sind, wird deren Verarbeitung auf diese Zwecke beschränkt. D.h., die Daten werden gesperrt und nicht für
            andere Zwecke verarbeitet. Das gilt z.B. für Daten, die aus handels- oder steuerrechtlichen Gründen
            aufbewahrt werden müssen oder deren Speicherung zur Geltendmachung, Ausübung oder Verteidigung von
            Rechtsansprüchen oder zum Schutz der Rechte einer anderen natürlichen oder juristischen Person erforderlich
            ist.</p>
        <p>Unsere Datenschutzhinweise können ferner weitere Angaben zu der Aufbewahrung und Löschung von Daten
            beinhalten, die für die jeweiligen Verarbeitungen vorrangig gelten.</p>
        <h2 id="m134">Einsatz von Cookies</h2>
        <p>Cookies sind Textdateien, die Daten von besuchten Websites oder Domains enthalten und von einem Browser auf
            dem Computer des Benutzers gespeichert werden. Ein Cookie dient in erster Linie dazu, die Informationen über
            einen Benutzer während oder nach seinem Besuch innerhalb eines Onlineangebotes zu speichern. Zu den
            gespeicherten Angaben können z.B. die Spracheinstellungen auf einer Webseite, der Loginstatus, ein Warenkorb
            oder die Stelle, an der ein Video geschaut wurde, gehören. Zu dem Begriff der Cookies zählen wir ferner
            andere Technologien, die die gleichen Funktionen wie Cookies erfüllen (z.B. wenn Angaben der Nutzer anhand
            pseudonymer Onlinekennzeichnungen gespeichert werden, auch als "Nutzer-IDs" bezeichnet)</p>
        <p><strong>Die folgenden Cookie-Typen und Funktionen werden unterschieden:</strong></p>
        <ul>
            <li><strong>Temporäre Cookies (auch: Session- oder Sitzungs-Cookies):</strong>&nbsp;Temporäre Cookies werden
                spätestens gelöscht, nachdem ein Nutzer ein Online-Angebot verlassen und seinen Browser geschlossen hat.
            </li>
            <li><strong>Permanente Cookies:</strong>&nbsp;Permanente Cookies bleiben auch nach dem Schließen des
                Browsers gespeichert. So kann beispielsweise der Login-Status gespeichert oder bevorzugte Inhalte direkt
                angezeigt werden, wenn der Nutzer eine Website erneut besucht. Ebenso können die Interessen von Nutzern,
                die zur Reichweitenmessung oder zu Marketingzwecken verwendet werden, in einem solchen Cookie
                gespeichert werden.
            </li>
            <li><strong>First-Party-Cookies:</strong>&nbsp;First-Party-Cookies werden von uns selbst gesetzt.</li>
            <li><strong>Third-Party-Cookies (auch: Drittanbieter-Cookies)</strong>: Drittanbieter-Cookies werden
                hauptsächlich von Werbetreibenden (sog. Dritten) verwendet, um Benutzerinformationen zu verarbeiten.
            </li>
            <li><strong>Notwendige (auch: essentielle oder unbedingt erforderliche) Cookies:</strong> Cookies können zum
                einen für den Betrieb einer Webseite unbedingt erforderlich sein (z.B. um Logins oder andere
                Nutzereingaben zu speichern oder aus Gründen der Sicherheit).
            </li>
            <li><strong>Statistik-, Marketing- und Personalisierungs-Cookies</strong>: Ferner werden Cookies im
                Regelfall auch im Rahmen der Reichweitenmessung eingesetzt sowie dann, wenn die Interessen eines Nutzers
                oder sein Verhalten (z.B. Betrachten bestimmter Inhalte, Nutzen von Funktionen etc.) auf einzelnen
                Webseiten in einem Nutzerprofil gespeichert werden. Solche Profile dienen dazu, den Nutzern z.B. Inhalte
                anzuzeigen, die ihren potentiellen Interessen entsprechen. Dieses Verfahren wird auch als "Tracking",
                d.h., Nachverfolgung der potentiellen Interessen der Nutzer bezeichnet. Soweit wir Cookies oder
                "Tracking"-Technologien einsetzen, informieren wir Sie gesondert in unserer Datenschutzerklärung oder im
                Rahmen der Einholung einer Einwilligung.
            </li>
        </ul>
        <p><strong>Hinweise zu Rechtsgrundlagen: </strong> Auf welcher Rechtsgrundlage wir Ihre personenbezogenen Daten
            mit Hilfe von Cookies verarbeiten, hängt davon ab, ob wir Sie um eine Einwilligung bitten. Falls dies
            zutrifft und Sie in die Nutzung von Cookies einwilligen, ist die Rechtsgrundlage der Verarbeitung Ihrer
            Daten die erklärte Einwilligung. Andernfalls werden die mithilfe von Cookies verarbeiteten Daten auf
            Grundlage unserer berechtigten Interessen (z.B. an einem betriebswirtschaftlichen Betrieb unseres
            Onlineangebotes und dessen Verbesserung) verarbeitet oder, wenn der Einsatz von Cookies erforderlich ist, um
            unsere vertraglichen Verpflichtungen zu erfüllen.</p>
        <p><strong>Speicherdauer: </strong>Sofern wir Ihnen keine expliziten Angaben zur Speicherdauer von permanenten
            Cookies mitteilen (z. B. im Rahmen eines sog. Cookie-Opt-Ins), gehen Sie bitte davon aus, dass die
            Speicherdauer bis zu zwei Jahre betragen kann.</p>
        <p><strong>Allgemeine Hinweise zum Widerruf und Widerspruch (Opt-Out): </strong> Abhängig davon, ob die
            Verarbeitung auf Grundlage einer Einwilligung oder gesetzlichen Erlaubnis erfolgt, haben Sie jederzeit die
            Möglichkeit, eine erteilte Einwilligung zu widerrufen oder der Verarbeitung Ihrer Daten durch
            Cookie-Technologien zu widersprechen (zusammenfassend als "Opt-Out" bezeichnet). Sie können Ihren
            Widerspruch zunächst mittels der Einstellungen Ihres Browsers erklären, z.B., indem Sie die Nutzung von
            Cookies deaktivieren (wobei hierdurch auch die Funktionsfähigkeit unseres Onlineangebotes eingeschränkt
            werden kann). Ein Widerspruch gegen den Einsatz von Cookies zu Zwecken des Onlinemarketings kann auch
            mittels einer Vielzahl von Diensten, vor allem im Fall des Trackings, über die Webseiten <a
                    href="https://optout.aboutads.info" target="_blank">https://optout.aboutads.info</a> und <a
                    href="https://www.youronlinechoices.com/" target="_blank">https://www.youronlinechoices.com/</a>
            erklärt werden. Daneben können Sie weitere Widerspruchshinweise im Rahmen der Angaben zu den eingesetzten
            Dienstleistern und Cookies erhalten.</p>
        <ul class="m-elements">
            <li><strong>Verarbeitete Datenarten:</strong> Nutzungsdaten (z.B. besuchte Webseiten, Interesse an Inhalten,
                Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).
            </li>
            <li><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</li>
            <li><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a. DSGVO), Berechtigte
                Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).
            </li>
        </ul>
        <h2 id="m367">Registrierung, Anmeldung und Nutzerkonto</h2>
        <p>Nutzer können ein Nutzerkonto anlegen. Im Rahmen der Registrierung werden den Nutzern die erforderlichen
            Pflichtangaben mitgeteilt und zu Zwecken der Bereitstellung des Nutzerkontos auf Grundlage vertraglicher
            Pflichterfüllung verarbeitet. Zu den verarbeiteten Daten gehören insbesondere die Login-Informationen
            (Nutzername, Passwort sowie eine E-Mail-Adresse).</p>
        <p>Im Rahmen der Inanspruchnahme unserer Registrierungs- und Anmeldefunktionen sowie der Nutzung des
            Nutzerkontos speichern wir die IP-Adresse und den Zeitpunkt der jeweiligen Nutzerhandlung. Die Speicherung
            erfolgt auf Grundlage unserer berechtigten Interessen als auch jener der Nutzer an einem Schutz vor
            Missbrauch und sonstiger unbefugter Nutzung. Eine Weitergabe dieser Daten an Dritte erfolgt grundsätzlich
            nicht, es sei denn, sie ist zur Verfolgung unserer Ansprüche erforderlich oder es besteht eine gesetzliche
            Verpflichtung hierzu.</p>
        <p>Die Nutzer können über Vorgänge, die für deren Nutzerkonto relevant sind, wie z.B. technische Änderungen, per
            E-Mail informiert werden.</p>
        <p><strong>Registrierung mit Pseudonymen</strong>: Nutzer dürfen statt Klarnamen Pseudonyme als Nutzernamen
            verwenden.</p>
        <p><strong>Löschung von Daten nach Kündigung</strong>: Wenn Nutzer ihr Nutzerkonto gekündigt haben, werden deren
            Daten im Hinblick auf das Nutzerkonto, vorbehaltlich einer gesetzlichen Erlaubnis, Pflicht oder Einwilligung
            der Nutzer, gelöscht.</p>
        <p>Es obliegt den Nutzern, ihre Daten bei erfolgter Kündigung vor dem Vertragsende zu sichern. Wir sind
            berechtigt, sämtliche während der Vertragsdauer gespeicherte Daten des Nutzers unwiederbringlich zu
            löschen.</p>
        <ul class="m-elements">
            <li><strong>Verarbeitete Datenarten:</strong> Bestandsdaten (z.B. Namen, Adressen), Kontaktdaten (z.B.
                E-Mail, Telefonnummern), Inhaltsdaten (z.B. Eingaben in Onlineformularen), Meta-/Kommunikationsdaten
                (z.B. Geräte-Informationen, IP-Adressen).
            </li>
            <li><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</li>
            <li><strong>Zwecke der Verarbeitung:</strong> Erbringung vertraglicher Leistungen und Kundenservice,
                Sicherheitsmaßnahmen, Verwaltung und Beantwortung von Anfragen.
            </li>
            <li><strong>Rechtsgrundlagen:</strong> Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1
                lit. b. DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).
            </li>
        </ul>
        <h2 id="m432">Community Funktionen</h2>
        <p>Die von uns bereitgestellten Community Funktionen erlauben es Nutzern miteinander in Konversationen oder
            sonst miteinander in einen Austausch zu treten. Hierbei bitten wir zu beachten, dass die Nutzung der
            Communityfunktionen nur unter Beachtung der geltenden Rechtslage, unserer Bedingungen und Richtlinien sowie
            der Rechte anderer Nutzer und Dritter gestattet ist.</p>
        <p><strong>Beiträge der Nutzer sind öffentlich</strong>: Die von Nutzern erstellten Beiträge und Inhalte sind
            öffentlich sichtbar und zugänglich.</p>
        <p><strong>Recht zur Löschung</strong>: Die Löschung von Beiträgen, Inhalten oder Angaben der Nutzer ist nach
            einer sachgerechten Abwägung im erforderlichen Umfang zulässig soweit konkrete Anhaltspunkte dafür bestehen,
            dass sie einen Verstoß gegen gesetzliche Regeln, unsere Vorgaben oder Rechte Dritter darstellen.</p>
        <p><strong>Schutz eigener Daten</strong>: Die Nutzer entscheiden selbst, welche Daten sie über sich innerhalb
            unseres Onlineangebotes preisgeben. Zum Beispiel, wenn Nutzer Angaben zur eigenen Person machen oder an
            Konversationen teilnehmen. Wir bitten die Nutzer ihre Daten zu schützen und persönliche Daten nur mit
            Bedacht und nur im erforderlichen Umfang zu veröffentlichen. Insbesondere bitten wir die Nutzer zu beachten,
            dass sie die Zugangsdaten ganz besonders schützen und sichere Passwörter verwenden müssen (d.h. vor allem
            möglichst lange und zufällige Zeichenkombinationen).</p>
        <ul class="m-elements">
            <li><strong>Verarbeitete Datenarten:</strong> Nutzungsdaten (z.B. besuchte Webseiten, Interesse an Inhalten,
                Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).
            </li>
            <li><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</li>
            <li><strong>Zwecke der Verarbeitung:</strong> Erbringung vertraglicher Leistungen und Kundenservice,
                Sicherheitsmaßnahmen.
            </li>
            <li><strong>Rechtsgrundlagen:</strong> Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1
                lit. b. DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).
            </li>
        </ul>
        <h2 id="m328">Plugins und eingebettete Funktionen sowie Inhalte</h2>
        <p>Wir binden in unser Onlineangebot Funktions- und Inhaltselemente ein, die von den Servern ihrer jeweiligen
            Anbieter (nachfolgend bezeichnet als "Drittanbieter”) bezogen werden. Dabei kann es sich zum Beispiel um
            Grafiken, Videos oder Stadtpläne handeln (nachfolgend einheitlich bezeichnet als "Inhalte”).</p>
        <p>Die Einbindung setzt immer voraus, dass die Drittanbieter dieser Inhalte die IP-Adresse der Nutzer
            verarbeiten, da sie ohne die IP-Adresse die Inhalte nicht an deren Browser senden könnten. Die IP-Adresse
            ist damit für die Darstellung dieser Inhalte oder Funktionen erforderlich. Wir bemühen uns, nur solche
            Inhalte zu verwenden, deren jeweilige Anbieter die IP-Adresse lediglich zur Auslieferung der Inhalte
            verwenden. Drittanbieter können ferner sogenannte Pixel-Tags (unsichtbare Grafiken, auch als "Web Beacons"
            bezeichnet) für statistische oder Marketingzwecke verwenden. Durch die "Pixel-Tags" können Informationen,
            wie der Besucherverkehr auf den Seiten dieser Webseite, ausgewertet werden. Die pseudonymen Informationen
            können ferner in Cookies auf dem Gerät der Nutzer gespeichert werden und unter anderem technische
            Informationen zum Browser und zum Betriebssystem, zu verweisenden Webseiten, zur Besuchszeit sowie weitere
            Angaben zur Nutzung unseres Onlineangebotes enthalten als auch mit solchen Informationen aus anderen Quellen
            verbunden werden.</p>
        <p><strong>Hinweise zu Rechtsgrundlagen:</strong> Sofern wir die Nutzer um deren Einwilligung in den Einsatz der
            Drittanbieter bitten, ist die Rechtsgrundlage der Verarbeitung von Daten die Einwilligung. Ansonsten werden
            die Daten der Nutzer auf Grundlage unserer berechtigten Interessen (d.h. Interesse an effizienten,
            wirtschaftlichen und empfängerfreundlichen Leistungen) verarbeitet. In diesem Zusammenhang möchten wir Sie
            auch auf die Informationen zur Verwendung von Cookies in dieser Datenschutzerklärung hinweisen.</p>
        <ul class="m-elements">
            <li><strong>Verarbeitete Datenarten:</strong> Nutzungsdaten (z.B. besuchte Webseiten, Interesse an Inhalten,
                Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).
            </li>
            <li><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</li>
            <li><strong>Zwecke der Verarbeitung:</strong> Bereitstellung unseres Onlineangebotes und
                Nutzerfreundlichkeit, Marketing, Profile mit nutzerbezogenen Informationen (Erstellen von
                Nutzerprofilen), Erbringung vertraglicher Leistungen und Kundenservice.
            </li>
            <li><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a. DSGVO), Berechtigte
                Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).
            </li>
        </ul>
        <p><strong>Eingesetzte Dienste und Diensteanbieter:</strong></p>
        <ul class="m-elements">
            <li><strong>Instagram-Plugins und -Inhalte:</strong> Instagram Plugins und -Inhalte - Hierzu können z.B.
                Inhalte wie Bilder, Videos oder Texte und Schaltflächen gehören, mit denen Nutzer Inhalte dieses
                Onlineangebotes innerhalb von Instagram teilen können. Dienstanbieter: <a
                        href="https://www.instagram.com" target="_blank">https://www.instagram.com</a>, Instagram Inc.,
                1601 Willow Road, Menlo Park, CA, 94025, USA; Website: <a href="https://www.instagram.com"
                                                                          target="_blank">https://www.instagram.com</a>;
                Datenschutzerklärung: <a href="https://instagram.com/about/legal/privacy" target="_blank">https://instagram.com/about/legal/privacy</a>.
            </li>
            <li><strong>OpenStreetMap:</strong> Wir binden die Landkarten des Dienstes "OpenStreetMap" ein, die auf
                Grundlage der Open Data Commons Open Database Lizenz (ODbL) durch die OpenStreetMap Foundation (OSMF)
                angeboten werden. Die Daten der Nutzer werden durch OpenStreetMap ausschließlich zu Zwecken der
                Darstellung der Kartenfunktionen und zur Zwischenspeicherung der gewählten Einstellungen verwendet. Zu
                diesen Daten können insbesondere IP-Adressen und Standortdaten der Nutzer gehören, die jedoch nicht ohne
                deren Einwilligung (im Regelfall im Rahmen der Einstellungen ihrer Mobilgeräte vollzogen) erhoben
                werden. Dienstanbieter: OpenStreetMap Foundation (OSMF); Website: <a href="https://www.openstreetmap.de"
                                                                                     target="_blank">https://www.openstreetmap.de</a>;
                Datenschutzerklärung: <a href="https://wiki.openstreetmap.org/wiki/Privacy_Policy" target="_blank">https://wiki.openstreetmap.org/wiki/Privacy_Policy</a>.
            </li>
        </ul>
        <h2 id="m15">Änderung und Aktualisierung der Datenschutzerklärung</h2>
        <p>Wir bitten Sie, sich regelmäßig über den Inhalt unserer Datenschutzerklärung zu informieren. Wir passen die
            Datenschutzerklärung an, sobald die Änderungen der von uns durchgeführten Datenverarbeitungen dies
            erforderlich machen. Wir informieren Sie, sobald durch die Änderungen eine Mitwirkungshandlung Ihrerseits
            (z.B. Einwilligung) oder eine sonstige individuelle Benachrichtigung erforderlich wird.</p>
        <p>Sofern wir in dieser Datenschutzerklärung Adressen und Kontaktinformationen von Unternehmen und
            Organisationen angeben, bitten wir zu beachten, dass die Adressen sich über die Zeit ändern können und
            bitten die Angaben vor Kontaktaufnahme zu prüfen.</p>
        <h2 id="m10">Rechte der betroffenen Personen</h2>
        <p>Ihnen stehen als Betroffene nach der DSGVO verschiedene Rechte zu, die sich insbesondere aus Art. 15 bis 21
            DSGVO ergeben:</p>
        <ul>
            <li><strong>Widerspruchsrecht: Sie haben das Recht, aus Gründen, die sich aus Ihrer besonderen Situation
                    ergeben, jederzeit gegen die Verarbeitung der Sie betreffenden personenbezogenen Daten, die aufgrund
                    von Art. 6 Abs. 1 lit. e oder f DSGVO erfolgt, Widerspruch einzulegen; dies gilt auch für ein auf
                    diese Bestimmungen gestütztes Profiling. Werden die Sie betreffenden personenbezogenen Daten
                    verarbeitet, um Direktwerbung zu betreiben, haben Sie das Recht, jederzeit Widerspruch gegen die
                    Verarbeitung der Sie betreffenden personenbezogenen Daten zum Zwecke derartiger Werbung einzulegen;
                    dies gilt auch für das Profiling, soweit es mit solcher Direktwerbung in Verbindung steht.</strong>
            </li>
            <li><strong>Widerrufsrecht bei Einwilligungen:</strong> Sie haben das Recht, erteilte Einwilligungen
                jederzeit zu widerrufen.
            </li>
            <li><strong>Auskunftsrecht:</strong> Sie haben das Recht, eine Bestätigung darüber zu verlangen, ob
                betreffende Daten verarbeitet werden und auf Auskunft über diese Daten sowie auf weitere Informationen
                und Kopie der Daten entsprechend den gesetzlichen Vorgaben.
            </li>
            <li><strong>Recht auf Berichtigung:</strong> Sie haben entsprechend den gesetzlichen Vorgaben das Recht, die
                Vervollständigung der Sie betreffenden Daten oder die Berichtigung der Sie betreffenden unrichtigen
                Daten zu verlangen.
            </li>
            <li><strong>Recht auf Löschung und Einschränkung der Verarbeitung:</strong> Sie haben nach Maßgabe der
                gesetzlichen Vorgaben das Recht, zu verlangen, dass Sie betreffende Daten unverzüglich gelöscht werden,
                bzw. alternativ nach Maßgabe der gesetzlichen Vorgaben eine Einschränkung der Verarbeitung der Daten zu
                verlangen.
            </li>
            <li><strong>Recht auf Datenübertragbarkeit:</strong> Sie haben das Recht, Sie betreffende Daten, die Sie uns
                bereitgestellt haben, nach Maßgabe der gesetzlichen Vorgaben in einem strukturierten, gängigen und
                maschinenlesbaren Format zu erhalten oder deren Übermittlung an einen anderen Verantwortlichen zu
                fordern.
            </li>
            <li><strong>Beschwerde bei Aufsichtsbehörde:</strong> Sie haben unbeschadet eines anderweitigen
                verwaltungsrechtlichen oder gerichtlichen Rechtsbehelfs das Recht auf Beschwerde bei einer
                Aufsichtsbehörde, insbesondere in dem Mitgliedstaat ihres gewöhnlichen Aufenthaltsorts, ihres
                Arbeitsplatzes oder des Orts des mutmaßlichen Verstoßes, wenn Sie der Ansicht sind, dass die
                Verarbeitung der Sie betreffenden personenbezogenen Daten gegen die Vorgaben der DSGVO verstößt.
            </li>
        </ul>
        <h2 id="m42">Begriffsdefinitionen</h2>
        <p>In diesem Abschnitt erhalten Sie eine Übersicht über die in dieser Datenschutzerklärung verwendeten
            Begrifflichkeiten. Viele der Begriffe sind dem Gesetz entnommen und vor allem im Art. 4 DSGVO definiert. Die
            gesetzlichen Definitionen sind verbindlich. Die nachfolgenden Erläuterungen sollen dagegen vor allem dem
            Verständnis dienen. Die Begriffe sind alphabetisch sortiert.</p>
        <ul class="glossary">
            <li><strong>Personenbezogene Daten:</strong> "Personenbezogene Daten“ sind alle Informationen, die sich auf
                eine identifizierte oder identifizierbare natürliche Person (im Folgenden "betroffene Person“) beziehen;
                als identifizierbar wird eine natürliche Person angesehen, die direkt oder indirekt, insbesondere
                mittels Zuordnung zu einer Kennung wie einem Namen, zu einer Kennnummer, zu Standortdaten, zu einer
                Online-Kennung (z.B. Cookie) oder zu einem oder mehreren besonderen Merkmalen identifiziert werden kann,
                die Ausdruck der physischen, physiologischen, genetischen, psychischen, wirtschaftlichen, kulturellen
                oder sozialen Identität dieser natürlichen Person sind.
            </li>
            <li><strong>Profile mit nutzerbezogenen Informationen:</strong> Die Verarbeitung von "Profilen mit
                nutzerbezogenen Informationen", bzw. kurz "Profilen" umfasst jede Art der automatisierten Verarbeitung
                personenbezogener Daten, die darin besteht, dass diese personenbezogenen Daten verwendet werden, um
                bestimmte persönliche Aspekte, die sich auf eine natürliche Person beziehen (je nach Art der
                Profilbildung können dazu unterschiedliche Informationen betreffend die Demographie, Verhalten und
                Interessen, wie z.B. die Interaktion mit Webseiten und deren Inhalten, etc.) zu analysieren, zu bewerten
                oder, um sie vorherzusagen (z.B. die Interessen an bestimmten Inhalten oder Produkten, das
                Klickverhalten auf einer Webseite oder den Aufenthaltsort). Zu Zwecken des Profilings werden häufig
                Cookies und Web-Beacons eingesetzt.
            </li>
            <li><strong>Verantwortlicher:</strong> Als "Verantwortlicher“ wird die natürliche oder juristische Person,
                Behörde, Einrichtung oder andere Stelle, die allein oder gemeinsam mit anderen über die Zwecke und
                Mittel der Verarbeitung von personenbezogenen Daten entscheidet, bezeichnet.
            </li>
            <li><strong>Verarbeitung:</strong> "Verarbeitung" ist jeder mit oder ohne Hilfe automatisierter Verfahren
                ausgeführte Vorgang oder jede solche Vorgangsreihe im Zusammenhang mit personenbezogenen Daten. Der
                Begriff reicht weit und umfasst praktisch jeden Umgang mit Daten, sei es das Erheben, das Auswerten, das
                Speichern, das Übermitteln oder das Löschen.
            </li>
        </ul>
        <p class="seal"><a href="https://datenschutz-generator.de/?l=de"
                           title="Rechtstext von Dr. Schwenke - für weitere Informationen bitte anklicken."
                           target="_blank" rel="noopener noreferrer nofollow">Erstellt mit kostenlosem
                Datenschutz-Generator.de von Dr. Thomas Schwenke</a></p>
    </section>
</main>
<!--- footer bar include-->
<?php
include "./includes/footer.php";
?>

</body>
</html>
