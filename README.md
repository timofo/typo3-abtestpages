# abtestpages

This extension supports TYPO3 administrators in performing A/B tests. This is useful when a site owner want to measure whether a new version improves or reduces user interaction compared to the current version.

Page properties get a new field "B Page" where you can provide the alternative page version. If the page is requested by the user, the extension checks wheter there is a B version specified. If this is the case, the version is selected by random. A cookie is set that remembers which version the user got (so there is no flip-flop if the user requests the page repeatedly). Once the cookie expires, the user is back to random at the next request.

Additional header information may be specified both for the original version as well as for the B version. This allows to track version differences in a web analysis tool such as Analytics. 

#### Info:
This extension depends on realurl.

#### Screenshot:
![abtestpages screenshot](https://www.illusion-factory.de/fileadmin/user_upload/abtestpages-images/abtestpages-screen.jpeg)
