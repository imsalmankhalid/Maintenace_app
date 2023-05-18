<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editable Excel Sheet</title>
    <link rel="stylesheet" href="xlsx.css">
</head>
<body>
    <div id="sheet-container"></div>

    <script src="xlsx.full.min.js"></script>
    <script>
        var file = 'smk.xlsx'; // Path to your local Excel file

        var reader = new FileReader();
        reader.onload = function(e) {
            var data = new Uint8Array(e.target.result);
            var workbook = XLSX.read(data, { type: 'array' });

            // Get the first sheet
            var worksheet = workbook.Sheets[workbook.SheetNames[0]];

            // Convert worksheet to HTML table
            var html = XLSX.utils.sheet_to_html(worksheet);

            // Display the HTML table in the container element
            document.getElementById('sheet-container').innerHTML = html;
        };

        // Read the Excel file as an array buffer
        reader.readAsArrayBuffer(file);
    </script>
</body>
</html>
