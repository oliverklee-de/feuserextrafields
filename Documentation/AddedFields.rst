.. _added-fields:

==================================
Fields added to the FE users table
==================================

In addition to the existing FE user fields, this extension adds the following
fields to the FE users table:

*  :php:`full salutation`, e.g., "Hello Mr. Klee" (to work around the futile
   problem of trying to automatically generate gender-specific salutations)
*  :php:`gender` (with the mappings from `sr_feuser_register`)
*  :php:`date_of_birth`
*  :php:`zone` (state/province)
*  :php:`department`
*  :php:`vat_in`
*  :php:`membership_number`
*  :php:`privacy` (privacy agreement accepted)
*  :php:`privacy_date_of_acceptance`
*  :php:`terms_acknowledged`
*  :php:`terms_date_of_acceptance`
*  :php:`status` (job status)
*  :php:`comments`
