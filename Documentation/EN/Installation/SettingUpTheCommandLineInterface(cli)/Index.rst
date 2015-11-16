﻿.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Setting up the command line interface (CLI)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This extension offers a command line interface to trigger actions
through the command line e.g. by a cronjob. It can be configured to
send reminders to the events' organizers

- if a confirmed event is about to begin, or

- if the speakers' cancelation deadline of a neither confirmed nor
  canceled event has just passed.

The reminders are e-mails with a localized text and the list of
registrations appended as CSV.

To setup the CLI, do the following:

#. Go to the User admin tool in the TYPO3 BE and create a BE user record
   with the user name “ **\_cli\_seminars** ”. There is no need to
   provide any further information, just set any password (you will not
   need it again), save and close.

#. Choose/create a FE page where to do some TS setup configuration for
   the CLI and configure the following:

- Set the option “ *sendCancelationDeadlineReminder* ” to 1 to enable
  the cancellation deadline reminder.

- For the option “ *sendEventTakesPlaceReminderDaysBeforeBeginDate* ”,
  set the number of days before an upcoming event, when to send a
  reminder to the organizers. Setting zero will disable this reminder
  about an event taking place.

- In order to customize the appended CSV, the options “
  *filenameForRegistrationsCsv* ”, “ *fieldsFromFeUserForEmailCsv* ”, “
  *fieldsFromAttendanceForEmailCsv* ” and “
  *showAttendancesOnRegistrationQueueInEmailCsv* ” are relevant. Please
  consider the corresponding section about CSV-File Attachmentfor more
  details.

#. In your cronjob definition, use the following command to start the
   script: **/[** absolute path of your TYPO3 installation
   **]/typo3/cli\_dispatch.phpsh seminars [** configuration page UID
   **]**


**CSV-File Attachment**
"""""""""""""""""""""""

The mails send via CLI can contain a CSV file with the registrations
to the event the mail is sent for. To customize the contents of the
CSV file use the following options:

- “ *fieldsFromAttendanceForEmailCsv* ” and “
  *fieldsFromFeUserForEmailCsv* ” customize the fields which are
  exported in the CSV file. Please note that the CSV files always
  contains the columns for the data from the registration records first
  and then data from the corresponding FE user record.

- “ *filenameForRegistrationsCsv* ” determines the name of the attached
  CSV file.

- “ *showAttendancesOnRegistrationQueueInEmailCsv* ” determines whether
  registrations on the waiting list, should also be exported via CSV.
