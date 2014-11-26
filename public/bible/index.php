<!doctype html>
<html ng-app="biblePlanApp">
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.4/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.4/angular-route.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.4/angular-resource.min.js"></script>
   
    <script src="app/js/controllers.js"></script>
     <script src="app/js/services.js"></script>

  </head>
  <body ng-controller="bibleCtrl">
    <div>
      <ul>
        <li ng-repeat="day in days.days ">
          <p>Day</p>
          <ul>
            <li ng-repeat="heading in day.headings">
              {{heading.book}} {{heading.start_chapter}}:{{heading.start_verse}} to {{heading.end_chapter}}:{{heading.end_verse }} : {{heading.heading_text }}
            </li>
          </ul>
        </li>
    </ul>
    </div>
  </body>
</html>