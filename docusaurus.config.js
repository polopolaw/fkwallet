// @ts-check
// Note: type annotations allow type checking and IDEs autocompletion

// const lightCodeTheme = require('prism-react-renderer/themes/github');
// const darkCodeTheme = require('prism-react-renderer/themes/dracula');

/** @type {import('@docusaurus/types').Config} */
const config = {
  title: 'FKWallet Laravel Package',
  tagline: 'Laravel package for fkwallet.io API integration',
  favicon: 'img/favicon.ico',

  url: 'https://polopolaw.github.io/fkwallet',
  baseUrl: '/',

  organizationName: 'polopolaw',
  projectName: 'fkwallet',

  onBrokenLinks: 'throw',
  markdown: {
    mermaid: false,
    format: 'mdx',
    hooks: {
      onBrokenMarkdownLinks: 'warn',
    },
  },

  i18n: {
    defaultLocale: 'en',
    locales: ['en'],
  },

  presets: [
    [
      'classic',
      /** @type {import('@docusaurus/preset-classic').Options} */
      ({
        docs: {
          routeBasePath: '/',
          sidebarPath: './sidebars.js',
          editUrl: 'https://github.com/polopolaw/fkwallet/tree/main/docs/',
        },
      }),
    ],
  ],

  themeConfig:
    /** @type {import('@docusaurus/preset-classic').ThemeConfig} */
    ({
      navbar: {
        title: 'FKWallet',
        logo: {
          alt: 'FKWallet Logo',
          src: 'img/logo.svg',
        },
        items: [
          {
            type: 'docSidebar',
            sidebarId: 'tutorialSidebar',
            position: 'left',
            label: 'Documentation',
          },
          {
            href: 'https://github.com/polopolaw/fkwallet',
            label: 'GitHub',
            position: 'right',
          },
        ],
      },
      footer: {
        style: 'dark',
        links: [
          {
            title: 'Docs',
            items: [
              {
                label: 'Quick Start',
                to: '/quickstart',
              },
              {
                label: 'API Reference',
                to: '/api-reference',
              },
            ],
          },
          {
            title: 'Community',
            items: [
              {
                label: 'GitHub',
                href: 'https://github.com/polopolaw/fkwallet',
              },
            ],
          },
        ],
        copyright: `Copyright © ${new Date().getFullYear()} polopolaw. Built with Docusaurus.`,
      },
      // prism: {
      //   theme: lightCodeTheme,
      //   darkTheme: darkCodeTheme,
      // },
    }),
};

module.exports = config;

