<?php

namespace {

    use ArchiPro\Silverstripe\EventDispatcher\Service\EventService;
    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\EventDispatcher\Symfony\Event;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\Form;
    use SilverStripe\Forms\FormAction;
    use SilverStripe\Forms\TextField;
    /**
     * @template T of Page
     * @extends ContentController<T>
     */
    class PageController extends ContentController
    {
        /**
         * An array of actions that can be accessed via a request. Each array element should be an action name, and the
         * permissions or conditions required to allow the user to access it.
         *
         * <code>
         * [
         *     'action', // anyone can access this action
         *     'action' => true, // same as above
         *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
         *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
         * ];
         * </code>
         *
         * @var array
         */
        private static $allowed_actions = [
            'Form',
            'success'
        ];

        protected function init()
        {
            parent::init();
            // You can include any CSS or JS required by your project here.
            // See: https://docs.silverstripe.org/en/developer_guides/templates/requirements/
        }

        public function Form()
        {
            return Form::create(
                $this,
                'Form',
                FieldList::create([
                    TextField::create('LogMe', 'Message'),
                ]),
                FieldList::create([
                    FormAction::create(
                        'doSubmit',
                        'Submit'
                    )
                ]),

            );
        }

        public function doSubmit(array $data, Form $form)
        {
            EventService::singleton()->dispatch(new FormSubmittedEvent($form->getName(), $data));
            return $this->redirect($this->Link('success'));
        }

        public function success()
        {
            return $this->renderWith('Page',[
                'Title' => 'Success',
                'Content' => 'Form submitted successfully',
                'Form' => null
            ]);
        }
    }
}
