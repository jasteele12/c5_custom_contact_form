# Custom Contact Form
A very basic contact form block that you can use as a starting point for creating your own custom form blocks with Concrete5. In my experience, this is a better solution than using the built-in "external_form" block as it does not suffer from many of the limitations of that approach (for example, see http://www.concrete5.org/community/forums/chat/external-form-with-own-controller/ -- or just search the forums for "external_form" to find other potential issues).

## Installation / Customization

1. Move the `custom_contact_form` directory from this repo's `blocks` directory to your site's top-level `blocks` directory (note: this is just a block, *not* a package -- so don't put it in your `packages` directory).
2. Rename the `custom_contact_form` directory as desired (should be the lowercase_and_underscore version of your block's name -- for example, "My Great Form" would get a directory name of "my_great_form").
3. Edit the `controller.php` file:
    * Change the class name to be a TitleCaseWithNoSpaces version of the block name (otherwise known as CamelCase), followed by `BlockController` -- for example, "My Great Form" would get a class name of `MyGreatFormBlockController`.
    * Change the block name and description. It is recommended that the name correspond with the directory and class names, but this is not a technical requirement (just avoids confusion).
    * Change the table name to `bt` followed by the CamelCase version of the block name -- for example, "My Great Form" would get a table name of `btMyGreatForm`.
4. Edit `db.xml` file so the table name matches what you set in `controller.php`.
5. Customize the form as needed. The view.php file contains the form html. The action_submit_form() method in controller.php responds to form submissions.
