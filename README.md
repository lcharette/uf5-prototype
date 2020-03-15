# UserFrosting 5 Prototype

This repo explores one possible incarnation of UserFrosting 5. The focus of this prototype is;
* Performance
* Maintainability
* Flexibility, particularly around supporting independent client side applications

Notable differences to v4;
* Sprinkles are standard composer dependencies with no special handling. `sprinkles.json` no longer exists. A single composer package could also delivery multiple sprinkles under this model, as they are not dynamically instantiated.
* Support for rendering views requires a separate sprinkle, this is to keep the core lean.
* Monolithic controllers have been superseeded by `Actions` modelled after the current Slim PHP boilerplate. This change should offer improved performance and extensibility.
* UserFrosting is now fully delivered by composer.

On the horizon;
* Generalised client side API, built to simplify integration with various ecosystems (e.g. server side rendered pages enhanced with scripts like v4, (P)React, Vue, Angular, Svelte)
* Support for themes. This will be a system that is deliberatly separate from sprinkles but operating in a similar fashion. The reasoning behind this is that dynamically loading a sprinkle may result in unexpected behaviours. The integration points available to themes will be limited with this in mind. Themes are expected to integrate in a fashion similar to Sprinkles, in that their instantiation is performed within the project itself (not auto-magically using reflection).
* How i18n and i10n will work
* The `bakery`
* Improving support for multi-node environments (e.g. Service Fabric and Kubernetes).
* The upgrade path for those on v4, more specifically how bundling and processing of assets will work (work in v4 at least means the required tools exist).
* How services can be swapped out (e.g. different ways of handling emails).
