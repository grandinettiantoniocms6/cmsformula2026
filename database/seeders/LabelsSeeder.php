<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class LabelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /* LABELS NUOVI  */

        $vet = [];
        $vet["it"] = "Ottieni indicazioni";
        $vet["en"] = "Get directions";
        $vet["fr"] = "Obtenir un itinéraire";
        $vet["de"] = "Wegbeschreibung";
        $vet["es"] = "Obtener direcciones";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\Label::firstOrCreate(["key" => "map-block-contact-gmap"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Facebook";
        $vet["en"] = "Facebook";
        $vet["fr"] = "Facebook";
        $vet["de"] = "Facebook";
        $vet["es"] = "Facebook";
        $vet["srb"] = "Facebook";
        $vet["ro"] = "Facebook";

        \App\Models\Label::firstOrCreate(["key" => "fb-block-contact-gmap"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Instagram";
        $vet["en"] = "Instagram";
        $vet["fr"] = "Instagram";
        $vet["de"] = "Instagram";
        $vet["es"] = "Instagram";
        $vet["srb"] = "Instagram";
        $vet["ro"] = "Instagram";

        \App\Models\Label::firstOrCreate(["key" => "insta-block-contact-gmap"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Linkedin";
        $vet["en"] = "Linkedin";
        $vet["fr"] = "Linkedin";
        $vet["de"] = "Linkedin";
        $vet["es"] = "Linkedin";
        $vet["srb"] = "Linkedin";
        $vet["ro"] = "Linkedin";

        \App\Models\Label::firstOrCreate(["key" => "linkedin-block-contact-gmap"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "WhatsApp";
        $vet["en"] = "WhatsApp";
        $vet["fr"] = "WhatsApp";
        $vet["de"] = "WhatsApp";
        $vet["es"] = "WhatsApp";
        $vet["srb"] = "WhatsApp";
        $vet["ro"] = "WhatsApp";

        \App\Models\Label::firstOrCreate(["key" => "whatsapp-block-contact-gmap"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Fax";
        $vet["en"] = "Fax";
        $vet["fr"] = "Fax";
        $vet["de"] = "Fax";
        $vet["es"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\Label::firstOrCreate(["key" => "fax-block-contact-gmap"],[
            "value" => $vet,
        ]);



        $vet = [];
        $vet["it"] = "TORNA SU";
        $vet["en"] = "SCROLL UP";
        $vet["fr"] = "DÉFILEZ VERS LE HAUT";
        $vet["de"] = "ZURÜCK ZUM SEITENANFANG";
        $vet["es"] = "DESPLAZARSE HACIA ARRIBA";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";

        \App\Models\Label::firstOrCreate(["key" => "torna-su"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "TORNA INDIETRO";
        $vet["en"] = "GO BACK";
        $vet["fr"] = "EN ARRIÈRE";
        $vet["de"] = "GEH ZURÜCK";
        $vet["es"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "back-to-page"],[
            "value" => $vet,
        ]);



        /* FINE LABELS NUOVI  */



        /* LABELS BLOCCO GRID */

        $vet = [];
        $vet["it"] = "Scarica PDF";
        $vet["en"] = "Download PDF";
        $vet["fr"] = "Télécharger PDF";
        $vet["de"] = "Herunterladen PDF";
        $vet["es"] = "Descargar PDF";
        $vet["srb"] = "Preuzimanje PDF";
        $vet["ro"] = "Descarca PDF";
        \App\Models\Label::firstOrCreate(["key" => "pdf-download"],[
            "value" => $vet,
        ]);

        /* LABELS BLOCCO DOCUMENTI */

        $vet = [];
        $vet["it"] = "Scarica";
        $vet["en"] = "Download";
        $vet["fr"] = "Télécharger";
        $vet["de"] = "Herunterladen";
        $vet["es"] = "Descargar";
        $vet["srb"] = "Preuzimanje";
        $vet["ro"] = "Descarca";
        \App\Models\Label::firstOrCreate(["key" => "title-document"],[
            "value" => $vet,
        ]);

        /* LABELS BLOCCO STORES */

        $vet = [];
        $vet["it"] = "TUTTI";
        $vet["en"] = "ALL";
        $vet["fr"] = "TOUT";
        $vet["de"] = "ALLE";
        $vet["es"] = "TODO";
        $vet["srb"] = "SVE";
        $vet["ro"] = "TOATE";
        \App\Models\Label::firstOrCreate(["key" => "all"],[
            "value" => $vet,
        ]);

        /* LABELS BLOCCO NEWS */

        $vet = [];
        $vet["it"] = "Leggi News";
        $vet["en"] = "Read News";
        $vet["fr"] = "Lire les nouvelles";
        $vet["de"] = "Nachrichten lesen";
        $vet["es"] = "Leer noticias";
        $vet["srb"] = "Read Nevs";
        $vet["ro"] = "Citiți Știri";
        \App\Models\Label::firstOrCreate(["key" => "read-news"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Torna alle News";
        $vet["en"] = "Back to News";
        $vet["fr"] = "Retour aux nouvelles";
        $vet["de"] = "Zurück zu den Neuigkeiten";
        $vet["es"] = "Volver a Noticias";
        $vet["srb"] = "Nazad na vesti";
        $vet["ro"] = "Înapoi la Știri";
        \App\Models\Label::firstOrCreate(["key" => "back-to-news"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ultime News";
        $vet["en"] = "Last News";
        $vet["fr"] = "Dernières nouvelles";
        $vet["de"] = "Letzte Neuigkeiten";
        $vet["es"] = "Últimas noticias";
        $vet["srb"] = "Poslednje vesti";
        $vet["ro"] = "Ultimele stiri";
        \App\Models\Label::firstOrCreate(["key" => "last-news"],[
            "value" => $vet,
        ]);

        /* LABELS DIV COOKIE POLICY - NO IUBENDA */

        $vet = [];
        $vet["it"] = "OK";
        $vet["en"] = "OK";
        $vet["fr"] = "D'accord";
        $vet["de"] = "OK";
        $vet["es"] = "Muy bien";
        $vet["srb"] = "U redu";
        $vet["ro"] = "Bine";
        \App\Models\Label::firstOrCreate(["key" => "cookiebar_ok"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Questo sito utilizza cookie tecnici ed analitici in forma anonima, per garantire la migliore esperienza di navigazione possibile.";
        $vet["en"] = "This site uses technical and analytical cookies in anonymized form, to ensure the best browsing experience.";
        $vet["fr"] = "Ce site utilise des cookies techniques et analytiques sous forme anonymisée, pour assurer la meilleure expérience de navigation.";
        $vet["de"] = "Diese Website verwendet technische und analytische Cookies in anonymisierter Form, um das beste Surferlebnis zu gewährleisten.";
        $vet["es"] = "Este sitio utiliza cookies técnicas y analíticas de forma anónima, para garantizar la mejor experiencia de navegación.";
        $vet["srb"] = "Ovaj sajt koristi tehničke i analitičke kolačiće u anonimnom obliku, kako bi osigurao najbolje iskustvo pregledanja.";
        $vet["ro"] = "Acest site folosește cookie-uri tehnice și analitice în formă anonimizată, pentru a asigura cea mai bună experiență de navigare.";
        \App\Models\Label::firstOrCreate(["key" => "cookiebar_message"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Leggi Informativa Privacy";
        $vet["en"] = "Read Privacy Policy";
        $vet["fr"] = "Lire la politique de confidentialité";
        $vet["de"] = "Lesen Sie die Datenschutzrichtlinie";
        $vet["es"] = "Leer política de privacidad";
        $vet["srb"] = "Pročitajte Politiku privatnosti";
        $vet["ro"] = "Citiți Politica de confidențialitate";
        \App\Models\Label::firstOrCreate(["key" => "cookiebar_leggi_informativa"],[
            "value" => $vet,
        ]);

        /* LABELS WHATSAPP */

        $vet = [];
        $vet["it"] = "Ciao! Come posso esserti utile?";
        $vet["en"] = "Hi! How can I help you?";
        $vet["fr"] = "Salut! Comment puis-je t'aider?";
        $vet["de"] = "Hallo! Womit kann ich Ihnen behilflich sein?";
        $vet["es"] = "¡Hola! ¿Le puedo ayudar en algo?";
        $vet["srb"] = "Zdravo! Kako vam mogu pomoći?";
        $vet["ro"] = "Bună! Cu ce vă pot ajuta?";
        \App\Models\Label::firstOrCreate(["key" => "placeholder_wapp"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Bisogno di aiuto? Chatta con noi su WhatsApp! Ti risponderemo il prima possibile!";
        $vet["en"] = "Need help? Chat with us on WhatsApp! We will get back to you as soon as possible!";
        $vet["fr"] = "Besoin d'aide? Discutez avec nous sur WhatsApp! Nous vous répondrons dès que possible !";
        $vet["de"] = "Brauchen Sie Hilfe? Chatten Sie mit uns auf WhatsApp! Wir werden uns so schnell wie möglich bei Ihnen melden!";
        $vet["es"] = "¿Necesitas ayuda? Chatea con nosotros en WhatsApp! ¡Nos pondremos en contacto contigo lo antes posible!";
        $vet["srb"] = "Potrebna pomoć? Razgovarajte sa nama na VhatsApp-u! Javićemo vam se što je pre moguće!";
        $vet["ro"] = "Nevoie de ajutor? Discutați cu noi pe WhatsApp! Vă vom reveni cât mai curând posibil!";
        \App\Models\Label::firstOrCreate(["key" => "descrizione_pulsante_wapp"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Servizio Clienti";
        $vet["en"] = "Customers Service";
        $vet["fr"] = "Service client";
        $vet["de"] = "Kundenservice";
        $vet["es"] = "Servicio de atención al cliente";
        $vet["srb"] = "Korisnički servis";
        $vet["ro"] = "Serviciul de relații cu clienții";
        \App\Models\Label::firstOrCreate(["key" => "sottotitolo_pulsante_wapp"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "WhatsApp";
        $vet["en"] = "WhatsApp";
        $vet["fr"] = "WhatsApp";
        $vet["de"] = "WhatsApp";
        $vet["es"] = "WhatsApp";
        $vet["srb"] = "WhatsApp";
        $vet["ro"] = "WhatsApp";
        \App\Models\Label::firstOrCreate(["key" => "titolo_pulsante_wapp"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Imposta una nuova password";
        $vet["en"] = "Set a new password";
        $vet["fr"] = "Définir un nouveau mot de passe";
        $vet["de"] = "Neues Passwort festlegen";
        $vet["es"] = "Establecer una nueva contraseña";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "changePassword-imposta-nuova-password"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Sei già registrato?";
        $vet["en"] = "Are you already registered?";
        $vet["fr"] = "Êtes-vous déjà inscrit?";
        $vet["de"] = "Sind Sie bereits registriert?";
        $vet["es"] = "¿Ya estás registrado?";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "changePassword-gia-registrato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Recupera la tua password";
        $vet["en"] = "Retrieve your password";
        $vet["fr"] = "Récupérez votre mot de passe";
        $vet["de"] = "Stellen Sie Ihr Passwort wieder her";
        $vet["es"] = "Recupera tu contraseña";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "recoveryPassword-recupera-psw"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Riceverai all'indirizzo E-mail di registrazione un messaggio contenente il link che ti consentirà di impostare una nuova password.";
        $vet["en"] = "You will receive a message at the registration email address containing the link that will allow you to set a new password.";
        $vet["fr"] = "Vous recevrez un message à votre adresse email d'inscription contenant le lien qui vous permettra de définir un nouveau mot de passe.";
        $vet["de"] = "Sie erhalten an Ihre Registrierungs-E-Mail-Adresse eine Nachricht mit dem Link, über den Sie ein neues Passwort festlegen können.";
        $vet["es"] = "Recibirá un mensaje en su dirección de correo electrónico de registro que contiene el enlace que le permitirá establecer una nueva contraseña.";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "recoveryPassword-recupera-psw-msg-1"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi";
        $vet["en"] = "Login";
        $vet["fr"] = "Se connecter";
        $vet["de"] = "Anmeldung";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "changePassword-login"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nuova Password *";
        $vet["en"] = "New Password *";
        $vet["fr"] = "Nouveau mot de passe *";
        $vet["de"] = "Neues Passwort *";
        $vet["es"] = "Nueva contraseña *";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "changePassword-recupera-psw"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Conferma Password *";
        $vet["en"] = "Confirm password *";
        $vet["fr"] = "Confirmez le mot de passe *";
        $vet["de"] = "Bestätige das Passwort *";
        $vet["es"] = "Confirmar Contraseña *";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "changePassword-conferma-nuova-password"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Modifica Password";
        $vet["en"] = "Change Password";
        $vet["fr"] = "Changer le mot de passe";
        $vet["de"] = "Passwort ändern";
        $vet["es"] = "Cambiar la contraseña";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "changePassword-modifica-password"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "E-mail *";
        $vet["en"] = "E-mail *";
        $vet["fr"] = "E-mail *";
        $vet["de"] = "Email *";
        $vet["es"] = "Correo electrónico *";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "recoveryPassword-recupera-psw-email"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Recupera Password";
        $vet["en"] = "Password recovery";
        $vet["fr"] = "Récupération de mot de passe";
        $vet["de"] = "Passwort-Wiederherstellung";
        $vet["es"] = "Recuperación de contraseña";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "recoveryPassword-recupera-psw-recupera-password"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nuovo Cliente?";
        $vet["en"] = "New Customer?";
        $vet["fr"] = "Nouveau client?";
        $vet["de"] = "Neukunde?";
        $vet["es"] = "¿Nuevo cliente?";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "recoveryPassword-recupera-psw-nuovo-cliente"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Registrati";
        $vet["en"] = "Sign in";
        $vet["fr"] = "Se connecter";
        $vet["de"] = "Anmelden";
        $vet["es"] = "Iniciar sesión";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "recoveryPassword-recupera-psw-registrati"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Sei già registrato?";
        $vet["en"] = "Are you already registered?";
        $vet["fr"] = "Êtes-vous déjà inscrit?";
        $vet["de"] = "Sind Sie bereits registriert?";
        $vet["es"] = "¿Ya estás registrado?";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "recoveryPassword-recupera-psw-gia-registrato"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi";
        $vet["en"] = "Log in";
        $vet["fr"] = "Se connecter";
        $vet["de"] = "Anmeldung";
        $vet["es"] = "Acceso";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "recoveryPassword-recupera-psw-accedi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Se già registrato?";
        $vet["en"] = "Already registered?";
        $vet["fr"] = "Déjà enregistré?";
        $vet["de"] = "Bereits registriert?";
        $vet["es"] = "¿Ya registrado?";
        $vet["ru"] = "";
        $vet["srb"] = "Već registrovani?";
        $vet["ro"] = "Deja înregistrat?";
        \App\Models\Label::firstOrCreate(["key" => "login-title-login"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi con le tue credenziali";
        $vet["en"] = "Log in with your credentials";
        $vet["fr"] = "Connectez-vous avec vos identifiants";
        $vet["de"] = "Melden Sie sich mit Ihren Zugangsdaten an";
        $vet["es"] = "Inicia sesión con tus credenciales";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "login-sottotitolo-login"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Registrati con Facebook";
        $vet["en"] = "Register with Facebook";
        $vet["fr"] = "Inscrivez-vous sur Facebook";
        $vet["de"] = "Mit Facebook registrieren";
        $vet["es"] = "Regístrate con Facebook";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "login-registrati-fb"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi con Google";
        $vet["en"] = "Sign in with Google";
        $vet["fr"] = "Connectez-vous avec Google";
        $vet["de"] = "Anmeldung mit Google";
        $vet["es"] = "Inicia sesión con Google";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "login-registrati-google"],[
            "value" => $vet,
        ]);


        $vet = [];
        $vet["it"] = "Accedi al tuo account";
        $vet["en"] = "Log in to your account";
        $vet["fr"] = "Connectez-vous à votre compte";
        $vet["de"] = "Ins Konto einloggen";
        $vet["es"] = "Ingrese a su cuenta";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "login-recupera-psw"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Password *";
        $vet["en"] = "Password *";
        $vet["fr"] = "Mot de passe *";
        $vet["de"] = "Passwort *";
        $vet["es"] = "Contraseña *";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "login-password-login"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Ricordami";
        $vet["en"] = "Remember me";
        $vet["fr"] = "Souviens-toi de moi";
        $vet["de"] = "Erinnere dich an mich";
        $vet["es"] = "Acuérdate de mí";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "login-ricorda-login"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Non ricordi la password?";
        $vet["en"] = "Don't remember your password?";
        $vet["fr"] = "Vous ne vous souvenez plus de votre mot de passe ?";
        $vet["de"] = "Passwort vergessen?";
        $vet["es"] = "¿No recuerdas tu contraseña?";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "login-password-dimenticata"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi";
        $vet["en"] = "Log in";
        $vet["fr"] = "Se connecter";
        $vet["de"] = "Anmeldung";
        $vet["es"] = "Acceso";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "login-login"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nuovo Cliente?";
        $vet["en"] = "New Customer?";
        $vet["fr"] = "Nouveau client?";
        $vet["de"] = "Neukunde?";
        $vet["es"] = "¿Nuevo cliente?";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "login-new-customer"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Registrazione Account";
        $vet["en"] = "Sign in";
        $vet["fr"] = "Enregistrement du Compte";
        $vet["de"] = "Kontoregistrierung";
        $vet["es"] = "Registro de cuenta";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "login-registra-account"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Creando un account potrai effettuare gli acquisti più velocemente, controllare lo stato degli ordini ed avere a disposizione lo storico di tutti gli ordini effettuati.";
        $vet["en"] = "By creating an account you can make purchases faster, check the status of orders and have the history of all orders placed at your disposal.";
        $vet["fr"] = "En créant un compte, vous pouvez effectuer des achats plus rapidement, vérifier l'état des commandes et avoir à votre disposition l'historique de toutes les commandes passées.";
        $vet["de"] = "Durch die Erstellung eines Kontos können Sie schneller einkaufen, den Status Ihrer Bestellungen prüfen und haben Zugriff auf die Historie aller getätigten Bestellungen.";
        $vet["es"] = "Al crear una cuenta podrás realizar compras más rápido, consultar el estado de los pedidos y tener a tu disposición el historial de todos los pedidos realizados.";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "login-descrizione-registrati"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Registrati";
        $vet["en"] = "Sign in";
        $vet["fr"] = "Se connecter";
        $vet["de"] = "Anmelden";
        $vet["es"] = "Iniciar sesión";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "login-registrati"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Registra Account";
        $vet["en"] = "Register Account";
        $vet["fr"] = "Créer un compte";
        $vet["de"] = "Account registrieren";
        $vet["es"] = "Registrar Cuenta";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-nuovo"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inserisci i tuoi dati in basso. Possiedi già un account?";
        $vet["en"] = "Enter your details below. Do you already have an account?";
        $vet["fr"] = "Entrez vos coordonnées ci-dessous. Avez-vous déjà un compte?";
        $vet["de"] = "Geben Sie unten Ihre Daten ein. Haben Sie bereits ein Konto?";
        $vet["es"] = "Ingrese sus datos a continuación. Ya tienes una cuenta?";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-info-1"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi";
        $vet["en"] = "Log in";
        $vet["fr"] = "Se connecter";
        $vet["de"] = "Anmeldung";
        $vet["es"] = "Acceso";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-accedi"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Registrati con Facebook";
        $vet["en"] = "Register with Facebook";
        $vet["fr"] = "Inscrivez-vous sur Facebook";
        $vet["de"] = "Mit Facebook registrieren";
        $vet["es"] = "Regístrate con Facebook";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-fb"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accedi con Google";
        $vet["en"] = "Sign in with Google";
        $vet["fr"] = "Connectez-vous avec Google";
        $vet["de"] = "Anmeldung mit Google";
        $vet["es"] = "Inicia sesión con Google";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-google"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Nome e Cognome *";
        $vet["en"] = "Name and Surname *";
        $vet["fr"] = "Nom et surnom *";
        $vet["de"] = "Name und Nachname *";
        $vet["es"] = "Nombre y apellido *";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-nome-cognome"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inserisci il tuo nome e cognome";
        $vet["en"] = "Please enter your first and last name";
        $vet["fr"] = "S'il-vous-plaît, entrer votre prénom et votre nom";
        $vet["de"] = "Bitte geben Sie Ihren Vor- und Nachnamen ein";
        $vet["es"] = "Por favor introduce tu primer nombre y apellido";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-inserisci-nome-cognome"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "E-mail *";
        $vet["en"] = "E-mail *";
        $vet["fr"] = "E-mail *";
        $vet["de"] = "Email *";
        $vet["es"] = "Correo electrónico *";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-email"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inserisci E-mail";
        $vet["en"] = "Enter your E-mail";
        $vet["fr"] = "Entrer votre Email";
        $vet["de"] = "Geben sie ihre E-Mail Adresse ein";
        $vet["es"] = "Introduce tu correo electrónico";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-inserisci-email"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "La tua E-mail sarà protetta nel nostro database.";
        $vet["en"] = "Your e-mail will be protected in our database.";
        $vet["fr"] = "Votre email sera protégé dans notre base de données.";
        $vet["de"] = "Ihre E-Mail wird in unserer Datenbank geschützt.";
        $vet["es"] = "Su correo electrónico estará protegido en nuestra base de datos.";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-info-2"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Telefono *";
        $vet["en"] = "Phone *";
        $vet["fr"] = "Téléphone *";
        $vet["de"] = "Telefon *";
        $vet["es"] = "Teléfono *";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-telefono"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Password *";
        $vet["en"] = "Password *";
        $vet["fr"] = "Mot de passe *";
        $vet["de"] = "Passwort *";
        $vet["es"] = "Contraseña *";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-psw2"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "La tua password deve contenere almeno 8 caratteri, una lettera maiuscola, una minuscola ed almeno un numero (non può contenere spazi e caratteri speciali).";
        $vet["en"] = "Your password must contain at least 8 characters, one capital letter, one lowercase letter and at least one number (it cannot contain spaces and special characters).";
        $vet["fr"] = "Votre mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule et au moins un chiffre (il ne peut pas contenir d'espaces ni de caractères spéciaux).";
        $vet["de"] = "Ihr Passwort muss mindestens 8 Zeichen, einen Großbuchstaben, einen Kleinbuchstaben und mindestens eine Zahl enthalten (es darf keine Leerzeichen und Sonderzeichen enthalten).";
        $vet["es"] = "Tu contraseña debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula y al menos un número (no puede contener espacios ni caracteres especiales).";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-info-3"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Conferma Password";
        $vet["en"] = "Confirm password";
        $vet["fr"] = "Confirmez le mot de passe";
        $vet["de"] = "Bestätige das Passwort";
        $vet["es"] = "Confirmar Contraseña";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-conferma-psw2"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "(*) Dichiaro di aver letto e compreso la Privacy Policy e acconsento al trattamento dei miei dati personali per usufruire dei servizi riservati agli utenti registrati.";
        $vet["en"] = "(*) I have read and understood the Privacy Policy and consent to the processing of my personal data to use the services reserved for registered users.";
        $vet["fr"] = "(*) J'ai lu et compris la politique de confidentialité et consens au traitement de mes données personnelles pour utiliser les services réservés aux utilisateurs enregistrés.";
        $vet["de"] = "(*) Ich habe die Datenschutzrichtlinie gelesen und verstanden und stimme der Verarbeitung meiner persönlichen Daten zur Nutzung der registrierten Benutzer vorbehaltenen Dienste zu.";
        $vet["es"] = "(*) He leído y comprendido la Política de Privacidad y consiento el tratamiento de mis datos personales para utilizar los servicios reservados a usuarios registrados.";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-letto-privacy"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accetto";
        $vet["en"] = "I Accept";
        $vet["fr"] = "J'accepte";
        $vet["de"] = "Ich akzeptiere";
        $vet["es"] = "Acepto";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-privacy"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Autorizzo il trattamento dei miei dati personali, per scopi di profilazione, di marketing e per l'iscrizione alla newsletter.";
        $vet["en"] = "I authorize the processing of my personal data, for profiling, marketing and newsletter subscription purposes.";
        $vet["fr"] = "J'autorise le traitement de mes données personnelles, à des fins de profilage, de marketing et d'abonnement à la newsletter.";
        $vet["de"] = "Ich stimme der Verarbeitung meiner personenbezogenen Daten zu Profilierungs-, Marketing- und Newsletterabonnementzwecken zu.";
        $vet["es"] = "Autorizo el tratamiento de mis datos personales, con fines de elaboración de perfiles, marketing y suscripción a newsletter.";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-info-4"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Accetto";
        $vet["en"] = "I Accept";
        $vet["fr"] = "J'accepte";
        $vet["de"] = "Ich akzeptiere";
        $vet["es"] = "Acepto";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-newsletter"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Registrati";
        $vet["en"] = "Sign in";
        $vet["fr"] = "Se connecter";
        $vet["de"] = "Anmelden";
        $vet["es"] = "Iniciar sesión";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "register-registrati-registrati-3"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inserisci E-mail";
        $vet["en"] = "Enter your E-mail";
        $vet["fr"] = "Entrer votre Email";
        $vet["de"] = "Geben sie ihre E-Mail Adresse ein";
        $vet["es"] = "Introduce tu correo electrónico";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "login-email-login"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Inserisci la tua Password";
        $vet["en"] = "Enter your Password";
        $vet["fr"] = "Tapez votre mot de passe";
        $vet["de"] = "Geben Sie Ihr Passwort ein";
        $vet["es"] = "Ingresa tu contraseña";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "login-password-login"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Password errata";
        $vet["en"] = "Password is wrong";
        $vet["fr"] = "";
        $vet["de"] = "";
        $vet["es"] = "";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "password-non-riconosciuta"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Utente non riconosciuto";
        $vet["en"] = "Unrecognized user";
        $vet["fr"] = "Utilisateur non reconnu";
        $vet["de"] = "Unbekannter Benutzer";
        $vet["es"] = "Usuario no reconocido";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "utente-non-riconosciuto"],[
            "value" => $vet,
        ]);

        $vet = [];
        $vet["it"] = "Utente non attivo";
        $vet["en"] = "Unrecognized user";
        $vet["fr"] = "Utilisateur non reconnu";
        $vet["de"] = "Unbekannter Benutzer";
        $vet["es"] = "Usuario no reconocido";
        $vet["ru"] = "";
        $vet["srb"] = "";
        $vet["ro"] = "";
        \App\Models\Label::firstOrCreate(["key" => "utente-non-attivo"],[
            "value" => $vet,
        ]);

















    }
}
