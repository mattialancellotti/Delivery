function find_template(str) {
  if (!str.includes('(') || !str.includes(')'))
    return null;

  /* Otherwise search for them */
  var first = str.indexOf('(');
  var last  = str.indexOf(')');

  /* Cheks if it is empty */
  if (last == first)
    return null;

  /* Template */
  var substr = str.substring(first, last);
  if (!substr.includes('${') || !substr.includes('}'))
    return null;

  /* Search for the template */
  var t_start = substr.indexOf('${');
  var t_end   = substr.indexOf('}');
  if (t_end-2 == t_start)
    return null;

  return substr.substring(t_start+2, t_end);
}

function apply_attr(htmlElement, attributes, supply) {
    for (var attr in attributes) {
      /* Searching and replacing */
      var str = find_template(attributes[attr]);
      if (str != null)
        htmlElement.setAttribute(attr, 
          attributes[attr].replace('${' + str + '}', supply[str]));
      else
        htmlElement.setAttribute(attr, attributes[attr]);
    }
}

function unboxJSON(htmlTable, JSONObject, attributes) {
  /* Preparing stuff */
  var table_body = document.getElementById(htmlTable);
  var row = document.createElement('tr');

  for (var el in JSONObject) {
    var column = document.createElement('td');

    apply_attr(column, attributes[1], JSONObject);
    column.innerHTML = JSONObject[el];

    row.appendChild(column);
  }

  apply_attr(row, attributes[0], JSONObject);

  table_body.appendChild(row);
}

function unboxJSONArray(htmlTable, JSONArray, attributes) {
  for (var obj in JSONArray)
    unboxJSON(htmlTable, JSONArray[obj], attributes);
}
