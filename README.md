
A WIP personal Symfony project created on March 27, 2017, 10:18 pm for my personal projects.

Dead line asap for a first stable but very light version.

:checkered_flag: well advanced

:bike: mandatory features for the 1st version

:tractor: mandatory features for the 2nd version

:oncoming_automobile: mandatory features for the 3st version

:airplane: mandatory features for the 4th version

:rocket: final version

T0D0:
=====

Shop pages contents:
- :bike: Dynamic data to frontend generation: navigation, page, blocs, ...
- :bike: :checkered_flag: Navigation
- :bike: :checkered_flag: Categories (2-level)
- :bike: :checkered_flag: Sliders
- :bike: :checkered_flag: Textes
- :bike: :checkered_flag: Images
- :bike: :checkered_flag: Videos
- :bike: :checkered_flag: Diaporama
- :bike: Documents
- :tractor: HTML / Ads Bloc
- :tractor: :checkered_flag: Products gallery
- :tractor: :checkered_flag: Product page
- :tractor: :checkered_flag: Product purchase forms
- :tractor: Products reviews and commentaries
- :tractor: Shipping form
- :tractor: Register product form
- :tractor: Contact form
- :tractor: Payment form
- :tractor: :checkered_flag: Widgets (maps)
- :tractor: :checkered_flag: Social interactions
- :tractor: CGV, CGU, ...
- :tractor: Dynamic route to frontend generation: urls, categories, pages, home, ...
- :tractor: 2 styles available
- :tractor: connexion to Analytics (Bing, Google, ...), Search console (Bing, Google, ...) 
- :oncoming_automobile: 7 styles available
- :oncoming_automobile: Newsletter subscription
- :oncoming_automobile: Live support
- :plane: Internal tracking: view, page views, element views, ip, session_id, user_id, ...
- :rocket: customization through GIT bundle
- :rocket: connexion to shopping feeds (Facebook, Amazon, GoogleShopping, ...)


Backoffice - CMS features:
- :tractor: Multi-sites management
- :bike: :checkered_flag: Manage Categories (N-level): images, description, ...
- :bike: :checkered_flag: Manage Navigation menu: name, tree, parent category, subcategories, category position, ...
- :bike: :checkered_flag: Manage Pages: name, url, category, ...
- :bike: :checkered_flag: Manage ages Structures: blocs, elements, ...
- :bike: :checkered_flag: Manage pages Routes: pages' urls, ...
- :bike: :checkered_flag: Manage Textes blocs: texte, display, ...
- :bike: :checkered_flag: Manage Images blocs: image, legend, sizes, ...
- :bike: :checkered_flag: Manage Diaporama blocs: images, size, dispay, legends, ...
- :bike: :checkered_flag: Manage Sets of textes or images or products
- :bike: :checkered_flag: Manage Images: sizes, crops, resize, ...
- :bike: :checkered_flag: Manage Products: name, descriptions, images, brand, weight, stock, facets (style, color, season, composant)
- :tractor: Move image from local disk to S3/Cloudfront
- :bike: Manage download document blocs: document, download button, ...
- :tractor: Manage forms blocs: 
- :tractor: Manage products widgets blocs : best sales, last sales, manual, checkout, ...
- :bike: Manage others widgets blocs : maps
- :bike: Manage social interactions blocs
- :bike: Manage footer 
- :bike: :checkered_flag: Manage URL
- :tractor: Manage CGV, CGU, ...
- :oncoming_automobile: Live support chat
- :oncoming_automobile: Manage newsletters subscribers
- :oncoming_automobile: Manage newsletters
- :tractor: Load front templates / styles
- :tractor: Load AMP front templates / style

Backoffice - Shop features:
- :tractor: :checkered_flag: Manage products
- :tractor: Manage stocks
- :tractor: :checkered_flag: Manage products images and descriptions
- :tractor: :checkered_flag: Manage products prices and promotions
- :tractor: Manage products commentaries and reviews
- :tractor: Manage orders
- :tractor: Manage shipings
- :tractor: Manage invoices
- :tractor: Manage transactions
- :tractor: Manage customers
- :oncoming_automobile: Manage currencies
- :oncoming_automobile: Manage taxes
- :oncoming_automobile: Manage shipping taxes and products weights
- :oncoming_automobile: Manage countries
- :oncoming_automobile: Mail transactions
- :oncoming_automobile: IRL transactions
- :plane: Manage languages
- :rocket: Mail marketing

Backoffice - Analytics features:
- :tractor: Dashboard
- :tractor: Reports on products: best sales, ...
- :tractor: Reports on transactions: processed, abandoned, validated, refunded, ...
- :plane: Reports on views
- :plane: Reports on customers: new customers, geo, ...
- :rocket: Cross reports on physical visits in real store

Backoffice - General features
- :bike: Project configuration: url, email, multi-users, copyright, ...
- :bike: Site configuration: site name, favicon, logo, description, address, phone, contact, social networks, cookies, ...
- :tractor: Shop configuration: payments, vat, languages, ...
- :oncoming_automobile: subdomain affectaion, DNS redirection configuration, ...
- :oncoming_automobile: Download / Import CMS and Shop elements
- :bike: :checkered_flag: Friendly UI
- :bike: :checkered_flag: User management
- :oncoming_automobile: API / FOSRest to access all CMS and Shop elements 
- :oncoming_automobile: Bakckoffice docs
- :bike: :checkered_flag: Mobile responsive
- :rocket: Project docs

SEO / Mobile first:
- :bike: :checkered_flag: OpenGraph, Twitter, ... meta
- :bike: :checkered_flag: Breadcrumbs Organization, Web, Product, Image, ... 
- :bike: :checkered_flag: Microdata Product, Image, ...
- :bike: Manage URLs
- :tractor: Manage sitemaps
- :bike: :checkered_flag: Manage optimized images
- :bike: :checkered_flag: Manage HTML main structured tags: title, h1, alt, ...
- :bike: Manage tracking tags: analytics, seach console, ...
- :bike: AMP slide
- :bike: AMP menu side
- :bike: AMP CMS and Shop bloc management
- :rocket: Track AMP READER_ID

Mobile App:
- :rocket: PWA customer app
- :rocket: Push notification
- :rocket: PWA merchant app for IRL transactions
- :rocket: Track localisation at physical store visit/purchase

Performances:
- :bike: :checkered_flag: Enable Redis cache of all frontend MySQL queries
- :bike: :checkered_flag: Enable Apache and http assets cache for front pages
- :bike: :checkered_flag: Enable Symfony header cache
- :bike: :checkered_flag: No-complex SQL queries (joined, non-indexed, ...), for ensuring database high scalability
- :bike: Enable Opcache and Symfony class autoload
- :bike: Enable AMP for full Google CDN http cache
- :rocket: Enable full CDN http cache by Symfony http headers

Developpement and customization:
- :bike: :checkered_flag: Use PHP v7
- :bike: :checkered_flag: Use MySQL v14
- :bike: :checkered_flag: Use Symfony3 for PHP framework
- :bike: :checkered_flag: Use Doctrine for data management
- :bike: :checkered_flag: Use Twig for template
- :bike: :checkered_flag: Use Redis for data cache
- :bike: :checkered_flag: Use Apache for assets and HTTP cache
- :bike: :checkered_flag: Use Bower for assets dependencies
- :bike: :checkered_flag: Use Composer for application dependencies
- :bike: Use AWS APIs
- :tractor: Unit tests

Architecture:
- :oncoming_automobile: Account creation
- :airplane: Deployment: reload, backup, flush, deploy, ...
- :bike: S3 files
- :airplane: EC2 servers and autoscaling
- :bike: Cloudfront CDN
- :bike: RDS database
- :oncoming_automobile: Route53 
- :oncoming_automobile: Backups, AMI
- :airplane: AWS API proxy interfaces
- :airplane: Sandbox

Payments
- :tractor: ...

