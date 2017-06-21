# datatable

A simple PHP implementation of DataTable (JavaScript library) protocol for returning server-side data. Please see the example in
index.html and data.php files.


To use this library in your project, simply create a data provider class that implements **Thant\DataTable\IDataProvider** interface and use its instance in conjunction with
**Thant\DataTable\Handler** class. Example implementation of interface IDataProvider can be found in **Thant\DataTable\DataProvider\ArrayList** class.



