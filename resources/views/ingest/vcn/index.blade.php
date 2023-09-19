<html>
    <body>
        <div id="vcnUsername">{{ env('VCN_USERNAME') }}</div>
        <div id="vcnPassword">{{ env('VCN_PASSWORD') }}</div>
        <div id="startDate">{{ now()->subDays(30)->format('m/d/Y') }}</div>
        <div id="endDate">{{ now()->format('m/d/Y') }}</div>

    </body>
</html>
