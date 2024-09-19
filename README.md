# amenofisch/pubscheduler
## A simple Typo3 extension to manage the publication of records in the future.

This extension introduces a new field in pages and tt_content records to be able to automatically reschedule content to be re-published in the future.

### Installation
1. Install the extension via composer: `composer require amenofisch/pubscheduler`
2. Install the extension via the extension manager
3. Add the scheduler task to your scheduler tasks

### Usage
After installing the extension any pages and content elements will receive a new field unter the "Access" tab called "Publication Type".  
It has the following options:
- Default: The record will be published as usual and obeys start and end time
- Daily: The record will be republished every day at the specified time
- Weekly: The record will be republished every week at the specified time
- Monthly: The record will be republished every month at the specified time
- Yearly: The record will be republished every year at the specified time


### How does it work?
The extension adds a new field to the pages and tt_content tables called `pubscheduler_publication_type`.
When the scheduler task is executed it will check all pages and adjust their start and end times accordingly.

### Contributing
1. Fork the repository
2. Create a new branch for your feature
3. Commit your changes
4. Push to the branch
5. Create a pull request
6. Wait for the review
7. Merge
8. Celebrate
9. Repeat

### License
This extension is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.