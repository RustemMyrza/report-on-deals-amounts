# report-on-deals-amounts
This project is about report by currency amounts of deals in Bitrix24

The report is made on the fields of the currency amount of deals, where the employee responsible for the deals is taken into account and the amount with which the employee worked is shown in the report. Reports are made only on a quarterly basis. The report is saveable, that is, it is saved in the Bitrix universal list.

The report itself interacts using the Bitrix webhook; to launch it, you also need the identifier of the deals amount fields on the basis of which you want to make a report, as well as the names of the columns in the universal list, and you need to insert the necessary links in the right places. The main places for editing are marked with comments in the code itself.
