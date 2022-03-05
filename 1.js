let data = ['11','12','cii','001','2','1998','7','89','iia','fii'];
let strings = data.filter(item => isNaN(item));


const lexicograplicaly = (string = '') => {
  let arr = string.split('');
  let result = [];
  for (let i = 1; i <= arr.length; i++) {
    let rows = []
    for (let x = 0; x < i; x++) {
      if(x === 0 || x === i - 1) {
        rows.push(arr[x]);
      }
    }
    rows.reverse()
    result.push(rows);
  }
  return result;
}

strings.map(str => {
  var lex = lexicograplicaly(str);
  console.log(lex);
})