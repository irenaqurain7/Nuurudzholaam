Template files for bulk schedule import

Location: public/templates/

Files included:
- Template_TK.csv and Template_TK.xlsx
- Template_SD.csv and Template_SD.xlsx
- Template_SMP.csv and Template_SMP.xlsx
- Template_SMK.csv and Template_SMK.xlsx

Notes:
- Each file uses columns: class,subject,day,start_time,end_time,teacher,room
- Use 24-hour time format for times (e.g. 08:00).
- The .csv files are standard CSV and can be opened by Excel.
- The .xlsx files in this folder are placeholders with CSV content; if you prefer proper .xlsx files, open the CSV in Excel and save as .xlsx.

How to use with the wizard:
- On Step 1 choose the appropriate `education_level`.
- Download the template that matches the jenjang.
- Fill rows for each schedule entry and upload via Step 2 -> Bulk Upload.

If you want, I can generate real .xlsx files (binary) using PHPSpreadsheet — tell me and I will add a small command or script to produce them.
