# Change log

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](https://semver.org/).

## x.y.z

### Added

### Changed

### Deprecated

### Removed

- Drop support for TYPO3 11LTS (#941)
- Drop the `username/password` parameters from the FE user constructor (#940)
- Drop support for PHP < 8.1 (#939)

### Fixed

## 6.7.1: Cleanup

### Changed

- Relax the type annotations for `FrontendUser.gender` (#922)

### Deprecated

- Mark `FrontendUser::VALID_GENDERS` and `::VALID_STATUS` as `@internal` (#923)

### Fixed

- Improve the type annotations (#934, #936)

## 6.7.0: Add membership number field

### Added

- Add `FrontendUser.membershipNumber` (#894)

### Changed

- Require the latest TYPO3 12LTS security release (#896)

## 6.6.0: Add department field

### Added

- Add a department field (#824)

### Changed

- Require the latest TYPO3 12LTS security release (#807)

# 6.5.1: Internal cleanup

No user-facing changes.

## 6.5.0: Add new features

### Added

- Add `FrontendUserRepository.findBySearchTermInBackendMode` (#776)
- Add `Frontenduser.getDisplayName()` (#775)

## 6.4.0: Add support for PHP 8.4

### Added

- Add `FrontendUser::getValidEmail()` (#747)
- Add support for PHP 8.4 (#725)

### Changed

- Require TYPO3 >= 11.5.41 (#692, #726, #746)

### Removed

- Remove unneeded `resname` from the language files (#729)

### Fixed

- Improve the type annotations (#678)

## 6.3.0

### Added

- Add a wrapper class for gender values (#624)
- Add `FrontendUser.vatIn` (VAT identification number) (#623)
- Add `FrontendUser.privacyDateOfAcceptance` (#622)
- Add `FrontendUser.termsDateOfAcceptance` (#620)

### Deprecated

- Deprecate the gender constants (#624)

### Fixed

- Fix some copy'n'paste errors with `resname` in the language file (#621)

## 6.2.2

### Fixed

- Set the default gender value to "none provided" in the SQL table definition
  (#599)

## 6.2.1

### Changed

- Add labels for `crdate` and `tstamp` (#557)

## 6.2.0

### Added

- Add a checkbox for "terms acknowledged" (#538)

### Fixed

- Make some DB fields visually smaller (#544)

## 6.1.1

### Changed

- Improve the annotations (#539)
- Raise the required TYPO3 bugfix version (#461)

### Removed

- Delete localizations that are now on Crowdin (#537)

### Fixed

- Add `resname` to all language labels (#535)
- Fix the minimum 12LTS version (#458)

## 6.1.0

### Added

- Add support for TYPO3 12LTS (#436, #437, #438, #440, #441)
- Add the Crowdin configuration (#428)

## 6.0.0

### Changed

- Use native type declarations for properties (#404, #405)

### Removed

- Drop `FrontendUserWithCountry` (#390)
- Drop the `fax` field (#388)
- Drop support for TYPO3 10LTS (#387, #410)
- Drop support for PHP 7.2/7.3 (#386)

## 5.4.0

### Added

- Add `.creationDate` and `.modificationDate` properties (#383)
- Add support for PHP 8.3 (#382)

### Changed

- Use short class names in the PHPDoc annotations (#336)
- Mention the 12LTS crowdfunding campaign (#333)

### Removed

- Drop the property mapping for the removed `lockToDomain` property (#325)

## 5.3.0

### Added

- Add a gender value "diverse" (#264)

### Deprecated

- Deprecate `FrontendUserWithCountry` and its repository (#265)

## 5.2.2

### Changed

- Require TYPO3 ^11.5.4 for TYPO3 11LTS (#259)
- Switch the coverage on CI from Xdebug to PCOV (#223)

### Fixed

- Enable caching for PHP-CS-Fixer (#248)

## 5.2.1

### Fixed

- Ignore the storage PID in `FrontendUserGroupRepository::findByUids` (#208)

## 5.2.0

### Added

- Add `FrontendUserGroupRepository::findByUids` (#207)

## 5.1.1

### Changed

- Require TYPO3 >= 10.4.11 (#173)

### Fixed

- Stop using the deprecated `TYPO3_MODE` constant (#175)

## 5.1.0

### Added

- Add support for PHP 8.2 (#158, #159)
- Add support for TYPO3 11LTS (#154, #155, #156)

### Removed

- Drop the Prophecy dependency (#151)

# 5.0.0

### Removed

- Drop the `locktodomain` property (#146)

## 4.2.1

### Added

- Add tests that the models can be XCLASSed (#143)

### Fixed

- Reduce code duplication in the repositories (#144)
- Bump the minimal 10.4 Extbase requirement (#137)

## 4.2.0

### Added

- Add length validation to the model properties (#109)
- Add `Repository.persistAll` (#90)
- Add tests concerning handling a user's PID (#75)

### Fixed

- Improve the type annotations (#107)

## 4.1.0

### Added

- Add `FrontendUser(WithCountry)Repository::existsWithUsername` (#69)
- Add `FrontendUser(WithCountry)Repository::findOneByUsername` (#68)

### Fixed

- Fix the German label for `static_info_country` (#68)

## 4.0.0

### Changed

- Reuse `initializeObject` from the constructor (#54)
- Switch the code coverage collection to Coveralls (#53)

### Removed

- Drop support for TYPO3 V9 (#49)

### Fixed

- Make sure the necessary directories get created when running the tests (#56)

## 3.0.0

Completely rewritten for TYPO3 V9/V10.
