let subjectMarks = [85, 90, 78, 92, 88];
let averageMarks = 0.0;
let totalMarks = 0;
for (let i = 0; i < subjectMarks.length; i++) {
  totalMarks += subjectMarks[i];
}
averageMarks = totalMarks / subjectMarks.length;
let result;
if (averageMarks >= 80) {
  result = "Distinction";
}
else if (averageMarks >= 60) {
  result = "First Division";
}
else if (averageMarks >= 40) {
  result = "Pass";
}
else if (averageMarks < 40) {
  result = "Fail";
}
console.log("Your Average is " + averageMarks +" and your result is " + result);