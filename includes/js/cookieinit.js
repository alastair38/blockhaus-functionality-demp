// obtain plugin

import 'https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.0.1/dist/cookieconsent.umd.js';

const analytics = WPVars.analytics
  ? 'We use analytics.'
  : 'We do not use analytics.';

const test = WPVars.media
  ? {
      title: 'Media',
      description:
        'Embedded content from third-party providers such as YouTube will set cookies once you view them on this website. This content is disabled by default. To view this content, enable the media setting.',
      linkedCategory: 'media',
    }
  : '';

const frame = document.querySelector('iframe');
function disableEmbed() {
  if (frame) {
    const dataSrc = frame.src;

    const videoId = dataSrc.substring(
      dataSrc.indexOf('d/') + 2,
      dataSrc.lastIndexOf('?')
    );

    // console.log(videoId);

    frame.style.backgroundImage = `url(https://i.ytimg.com/vi/${videoId}/hqdefault.jpg)`;
    frame.style.backgroundSize = 'cover';

    frame.setAttribute('data-src', dataSrc);
    frame.src = ``;
  }
}
disableEmbed();

function enableEmbed() {
  if (frame) {
    const dataSrc = frame.getAttribute('data-src');
    frame.src = `${dataSrc}`;
    const btnWrapper = document.querySelector(
      '.wp-block-blockhaus-cookie-consent-wrapper'
    );
    btnWrapper.style.display = 'none';
  }
}
/**
 * All config. options available here:
 * https://cookieconsent.orestbida.com/reference/configuration-reference.html
 */
CookieConsent.run({
  onFirstConsent: ({ cookie }) => {
    console.log('onFirstConsent fired', cookie);

    // onFirstConsent, if analytics category is enabled => enable google analytics as consent should be denied by default

    if (CookieConsent.acceptedCategory('analytics')) {
      console.log('Analytics not consented');
      typeof gtag === 'function' &&
        gtag('consent', 'update', {
          ad_storage: 'granted',
          ad_user_data: 'granted',
          ad_personalization: 'granted',
          analytics_storage: 'granted',
        });
    }
  },
  onConsent: function (cookie) {
    console.log('onConsent fired on every page load!');
  },

  onChange: function (cookie, changed_preferences) {
    console.log('onChange fired!');

    // If analytics category is enabled onChange => enable google analytics.

    if (CookieConsent.acceptedCategory('analytics')) {
      console.log('Analytics not consented');
      typeof gtag === 'function' &&
        gtag('consent', 'update', {
          ad_storage: 'granted',
          ad_user_data: 'granted',
          ad_personalization: 'granted',
          analytics_storage: 'granted',
        });
    }

    // If analytics category is disabled onChange => disable google analytics.

    if (!CookieConsent.acceptedCategory('analytics')) {
      console.log('Analytics not consented');
      typeof gtag === 'function' &&
        gtag('consent', 'update', {
          ad_storage: 'denied',
          ad_user_data: 'denied',
          ad_personalization: 'denied',
          analytics_storage: 'denied',
        });
    }
  },

  categories: {
    necessary: {
      enabled: true, // this category is enabled by default
      readOnly: true, // this category cannot be disabled
    },

    ...(WPVars.media
      ? {
          media: {
            enabled: false,
            services: {
              youtube: {
                label: 'YouTube',
                onAccept: () => {
                  enableEmbed();
                },
                onReject: () => {
                  disableEmbed();
                },
              },
            },
            autoClear: {},
          },
        }
      : {}),
    ...(WPVars.analytics && {
      analytics: {
        enabled: false,
      },
    }),
  },

  language: {
    default: 'en',
    autoDetect: 'document',
    translations: {
      en: {
        consentModal: {
          title: '🍪 We use cookies',
          description: 'Click on "Manage Individual preferences" for details',
          acceptAllBtn: 'Accept all',
          acceptNecessaryBtn: 'Reject all',
          showPreferencesBtn: 'Manage Individual preferences',
        },
        preferencesModal: {
          title: '🍪 Manage cookie preferences',
          acceptAllBtn: 'Accept all',
          acceptNecessaryBtn: 'Reject all',
          savePreferencesBtn: `${
            (WPVars.media || WPVars.analytics) && 'Accept current selection'
          }`,
          closeIconLabel: 'Close modal',
          sections: [
            {
              title: 'Overview',
              description: `<ul><li>This website uses session cookies to manage user logins and comments. No session cookies are set for site visitors who are not logged in or leaving comments.</li> 
              
              ${
                WPVars.media &&
                `<li>To view embedded media content on this site, enable the media setting.</li>`
              } 
              
              ${
                WPVars.analytics
                  ? `<li>This website uses analytics.</li>`
                  : `<li>This website DOES NOT use analytics to track you.</li>`
              }</ul> Manage your preferences below.`,
            },
            {
              title: 'Strictly Necessary cookies',
              description:
                'This website uses session cookies to manage user logins and comments. These cookies are essential for the proper functioning of the website and cannot be disabled.',

              //this field will generate a toggle linked to the 'necessary' category
              linkedCategory: 'necessary',
            },

            ...(WPVars.media && [
              {
                title: 'Media',
                description:
                  'If enabled, embedded media content from third-party provides such as YouTube will set cookies once you view it on this website.',
                linkedCategory: 'media',
              },
            ]),
            ...(WPVars.analytics && [
              {
                title: 'Performance and Analytics',
                description:
                  'These cookies collect information about how you use our website. All of the data is anonymized and cannot be used to identify you.',
                linkedCategory: 'analytics',
              },
            ]),

            {
              title: 'Privacy Policy',
              description:
                'You can view this at our <a href="' +
                WPVars.privacy_page +
                '">Privacy policy page</a>. For any queries in relation to our policy on cookies and your choices, please <a href="' +
                WPVars.contact_page +
                '">contact us</a>',
            },
          ],
        },
      },
      de: {
        consentModal: {
          title: '🍪 Wir verwenden Cookies',
          description: 'Klicken Sie auf "Einstellungen verwalten" für Details',
          acceptAllBtn: 'Alle akzeptieren',
          acceptNecessaryBtn: 'Alle ablehnen',
          showPreferencesBtn: 'Einstellungen verwalten',
        },
        preferencesModal: {
          title: '🍪 Einstellungen verwalten',
          acceptAllBtn: 'Alle akzeptieren',
          acceptNecessaryBtn: 'Alle ablehnen',
          savePreferencesBtn: `${
            (WPVars.media || WPVars.analytics) && 'Einstellungen speichern'
          }`,
          closeIconLabel: 'Modal schließen',
          sections: [
            {
              title: 'Übersicht',
              description: `<ul><li>Diese Website verwendet Sitzungscookies, um Benutzeranmeldungen und Kommentare zu verwalten. Für Besucher der Website, die nicht angemeldet sind oder Kommentare hinterlassen, werden keine Sitzungscookies gesetzt.</li> 
              
              ${
                WPVars.media &&
                `<li>Um eingebettete Medieninhalte auf dieser Website anzuzeigen, aktivieren Sie die Medieneinstellung.</li>`
              } 
              
              ${
                WPVars.analytics
                  ? `<li>Diese Website verwendet Analysefunktionen.</li>`
                  : `<li>Diese Website verwendet KEINE Analytik.</li>`
              }</ul>Verwalten Sie Ihre Einstellungen unten.`,
            },
            {
              title:
                'Streng Notwendige Cookies <span class="pm__badge">Immer Aktiviert</span>',
              description:
                'Diese Website verwendet Sitzungscookies, um Benutzeranmeldungen und Kommentare zu verwalten. Diese Cookies sind für das ordnungsgemäße Funktionieren der Website unerlässlich und können nicht deaktiviert werden.',

              //this field will generate a toggle linked to the 'necessary' category
              linkedCategory: 'necessary',
            },

            ...(WPVars.media && [
              {
                title: 'Medien',
                description:
                  'Wenn diese Funktion aktiviert ist, werden bei eingebetteten Medieninhalten von Drittanbietern wie YouTube Cookies gesetzt, sobald Sie diese auf dieser Website ansehen.',
                linkedCategory: 'media',
              },
            ]),
            ...(WPVars.analytics && [
              {
                title: 'Analytische Cookies',
                description:
                  'Diese Cookies sammeln Informationen darüber, wie Sie unsere Website nutzen. Alle Daten sind anonymisiert und können nicht dazu verwendet werden, Sie zu identifizieren.',
                linkedCategory: 'analytics',
              },
            ]),

            {
              title: 'Datenschutz',
              description:
                'Sie können dies auf unserer Seite zum <a href="' +
                WPVars.privacy_page_de +
                '">Datenschutz nachlesen</a>. Sie Fragen zu unserer Cookie-Politik und Ihren Wahlmöglichkeiten haben, <a href="' +
                WPVars.contact_page_de +
                '">kontaktieren Sie uns bitte.</a>',
            },
          ],
        },
      },
      fr: {
        consentModal: {
          title: '🍪 Nous utilisons des cookies',
          description:
            'Cliquez sur "Gérer les préférences" pour plus de détails',
          acceptAllBtn: 'Tout accepter',
          acceptNecessaryBtn: 'Tout rejeter',
          showPreferencesBtn: 'Gérer les préférences',
        },
        preferencesModal: {
          title: '🍪 Préférences de cookies',
          acceptAllBtn: 'Tout accepter',
          acceptNecessaryBtn: 'Tout rejeter',
          savePreferencesBtn: `${
            (WPVars.media || WPVars.analytics) && 'Sauvegarder les préférences'
          }`,
          closeIconLabel: 'Fermer la modale',
          sections: [
            {
              title: 'Aperçu',
              description: `<ul><li>Ce site web utilise des cookies de session pour gérer les connexions et les commentaires des utilisateurs. Aucun cookie de session n'est installé pour les visiteurs du site qui ne sont pas connectés ou qui ne laissent pas de commentaires.</li> 
              
              ${
                WPVars.media &&
                `<li>Pour afficher les contenus multimédias intégrés sur ce site, activez les paramètres multimédias.</li>`
              } 
              
              ${
                WPVars.analytics
                  ? `<li>Ce site web utilise des outils d'analyse.</li>`
                  : `<li>Ce site n'utilise pas d'outils d'analyse.</li>`
              }</ul> Gérer les préférences ci-dessous.`,
            },
            {
              title:
                'Cookies Strictement Nécessaires <span class="pm__badge">Toujours Activé</span>',
              description:
                'Ce site web utilise des cookies de session pour gérer les connexions et les commentaires des utilisateurs. Ces cookies sont essentiels au bon fonctionnement du site web et ne peuvent pas être désactivés.',

              //this field will generate a toggle linked to the 'necessary' category
              linkedCategory: 'necessary',
            },

            ...(WPVars.media && [
              {
                title: 'Médias',
                description:
                  "S'il est activé, le contenu multimédia intégré provenant de fournisseurs tiers tels que YouTube installera des cookies une fois que vous l'aurez visionné sur ce site web.",
                linkedCategory: 'media',
              },
            ]),
            ...(WPVars.analytics && [
              {
                title: 'Cookies Analytiques',
                description:
                  'Ces cookies recueillent des informations sur la manière dont vous utilisez notre site web. Toutes les données sont anonymes et ne peuvent être utilisées pour vous identifier.',
                linkedCategory: 'analytics',
              },
            ]),

            {
              title: 'Politique de confidentialité',
              description:
                'Vous pouvez les consulter sur notre page consacrée à la protection de la vie <a href="' +
                WPVars.privacy_page_fr +
                '">politique de confidentialité</a>. Pour toute question relative à notre politique en matière de cookies et à vos choix, veuillez <a href="' +
                WPVars.contact_page_fr +
                '">nous contacter.</a>',
            },
          ],
        },
      },
    },
  },
});
