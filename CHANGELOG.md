# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).
There is very high probability for breaking changes on every release before 1.0.0.

## [Unreleased]
### Added
- Decent docs with manual and API documentation
- CHANGELOG
- Root MetaClassException
- Abstract Component
### Changed
- README changed from manual to road map.
- Support functions split to categories: mutation, normalization, prediction
- Code docs cleanup
- Code coverage config added to phpunit.xml

## [0.3.0] - 2017-01-11
### Added
- Components and Meta Composition
- ComposeExceptions
- Composable Interface for components
- MetaExpansible Interface for meta child objects
- Support functions in categories: normalization and predicates
### Changed
- Abstract MetaClass changed to Meta basic implementation
- Inheritance chain better reflect purpose of package
- MetaClass Trait moved from Trait namespace to MetaClass namespace
- All meta objects moved from Models namespace to MetaClass namespace
### Removed
- Discovery module because does not fit with package responsibility

## [0.2.1] - 2017-01-07
### Changed
- Services namespace renamed to Connections

## [0.2.0] - 2017-01-07
### Added
- Abstract MetaClass
- Discovery module for model db schema sniffing
- Laravel db connection class for Discovery module
- Meta object tries to autoload db schema
### Removed
- ForbiddenException

## 0.1.0 - 2016-12-31
### Added
- Basic meta object implementation
- MetaClass Trait with meta() interface
- initMeta() interface
- Basic model binding to meta object

[Unreleased]: https://github.com/pawelzny/meta-class/compare/v0.3.0...HEAD
[0.3.0]: https://github.com/pawelzny/meta-class/compare/v0.2.1...v0.3.0
[0.2.1]: https://github.com/pawelzny/meta-class/compare/v0.2.0...v0.2.1
[0.2.0]: https://github.com/pawelzny/meta-class/compare/v0.1.0...v0.2.0
