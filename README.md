# UserFrosting 5 Prototype

This repo explores one possible incarnation of UserFrosting 5. The goal is to extract the UserFrosting framework entirely into a separate package such that indivudal projects have more flexibility around their preferred workflows, and to permit the creation of maintainable project skeletons.

It is expected that the change explored here will present a major breaking change, but one that doesn't require a complete refactor of an existing project. To this end the prototype will try to maintain existing conventions and attempt to constrain the scope to limit the number of breaking changes.

Notable differences to v4;
* Any vendor package with a type of `userfrosting-sprinkle` will be loaded, meaning sprinkles can specify compatibility contraints and dependencies.
  * Load order is resolved from the dependency graph to ensure correct load order automatically. This may be overridden if required.
  * Project code is always loaded last, such that it always overrides and can safely depend on resources from required sprinkles.
* Your actual project source is a superset of a sprinkle.
* UserFrosting is now fully delivered by composer.
* Strict adherence to semantic versioning, such that upgrade guides should not be required for feature level releases. This will likely mean major version bumps occuring at an increased pace, however updates will also be delivered sooner.
* Improved support for multi-node environments such as AWS Elastic Beanstalk, Azure Service Fabric, and Kubernetes.

## Looking Forward

Building on the changes that would be brought with the v5 prototype, the following will be investigated and (if appropriate) implemented.

* Decoupling of view component to support client side application models including;
  * A generalised client side API that can be easily used with (P)React, Vue, Angular, Svelte, and the existing server side setup.
  * New project skeletons built.
  * Revision of i18n and i10n support to permit a single source of truth across server and client apps.
* Theme support. Conditional loading of sprinkles is easy to achieve, however themes need to go beyond this to ensure logic remains unchanged for security and system integrity.
* Revision of services provider such that autocompletion is possible. If possible, this will almost definitely translate to a major revision of how Sprinkles are loaded.
