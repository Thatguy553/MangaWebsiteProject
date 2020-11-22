<h1>API Usage.</h1>
<bold>Delete Series:</bold> Send JSON with UID to /api/deleteSeries.php. (Not for public use)
{
    "UID": "1"
}

<bold>Display Series:</bold> Displays JSON in an array to list every series in the database, example JSON below.
{"body":
[{
"UID":"",
"Title":"",
"Description":"",
"Chapters":"0"
}]

<bold>UID:</bold> The unique series Identifier.
<bold>Title:</bold> The name of the series.
<bold>Description:</bold> The description of the series.
<bold>Chapters:</bold> The amount of chapters that series contains.

<bold>Insert Series:</bold> Send JSON containing Title, Description, and Chapters to /api/insertSeries.php. (Not for public use)
{
"Title": "",
"Description": "",
"Chapters": ""
}

<bold>Search for series:</bold> Fetch JSON from a url containing URL Vars with the series UID.
<bold>Example Usage:</bold> Fetch URL /api/searchSeries.php?UID=1
This will either list the series that has that UID or it will say "No Series Found".

<bold>Update Series:</bold> Send JSON containing the values you wish to update to /api/updateSeries.php
{
"Title": "",
"Description": "",
"Chapters": ""
}

<bold>Delete Series:</bold> Send JSON containing the series UID you wish to delete to /api/deleteSeries.php.
{
"UID": ""
}
