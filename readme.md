<h1>API Usage.</h1>

<p><h3>Delete Series:</h3> Send JSON with UID to /api/deleteSeries.php. (Not for public use)</p>

<p>{
    "UID": "1"
}</p>

<p><h3>Display Series:</h3> Displays JSON in an array to list every series in the database, example JSON below.</p>

<p>{"body":
[{
"UID":"",
"Title":"",
"Description":"",
"Chapters":"0"
}]</p>

<p><h3>UID:</h3> The unique series Identifier.</p>
<p><h3>Title:</h3> The name of the series.</p>
<p><h3>Description:</h3> The description of the series.</p>
<p><h3>Chapters:</h3> The amount of chapters that series contains.</p>

<p><h3>Insert Series:</h3> Send JSON containing Title, Description, and Chapters to /api/insertSeries.php. (Not for public use)</p>
<p>{
"Title": "",
"Description": "",
"Chapters": ""
}</p>

<p><h3>Search for series:</h3> Fetch JSON from a url containing URL Vars with the series UID.</p>
<p><h3>Example Usage:</h3> Fetch URL /api/searchSeries.php?UID=1</p>
<p>This will either list the series that has that UID or it will say "No Series Found".</p>

<p><h3>Update Series:</h3> Send JSON containing the values you wish to update to /api/updateSeries.php</p>
<p>{
"Title": "",
"Description": "",
"Chapters": ""
}</p>

<p><h3>Delete Series:</h3> Send JSON containing the series UID you wish to delete to /api/deleteSeries.php.</p>
<p>{
"UID": ""
}</p>
