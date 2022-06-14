# Specs RafrikiGarage

## Description

CuryGarage is a tool to keep status update of vehicles in a car workshop.

## User Types

The system has one type of `user`:

* `Admin`

## Common Usage

The `Admin` will be presented a screen with a gallery of cars which actually
are in the workshop. Each picture will have a footer that will indicate
the registration plate and the state of the vehicle.

### There, the `Admin` will be able to do the following:

* Will be redirected to a new `Customer Profile` page.

* Will be redirected to a new `Car Profile` page.

* Will be redirected to a search specific `Customer Profile` page.

* Will be redirected to a search specific `Car Profile` page.

* Will be redirected  new `Worksheet` page.

* Select an existing `Worksheet` to view its details, change state, even edit the 
details of the work to be done.

### Into the  new `Customer Profile` page will be able to do the following:

* Create a new `Customer Profile`: 

  * `Customer Profile` have the following information:
  
    * `Name`
    
    * `SurName`
    
    * `ID Card`
    
    * `Telephone Number`
    
    * `Email`

### Into the new `Car Profile` page will be able to do the following:

* Create a new `Car Profile`:

    * `Customer Profile` have the following information:
  
        * `Registration Plate`
      
        * `Chasis Number`
      
        * `Brand`
      
        * `Model`
      
        * `Engine Type`

__Attention__: The `Car Profiler` has to be linked to a `Customer Profile`.

### Into the search `Customer Profile` page will be able to do the following:

* Search a specific `Customer Profile` and visualize it.

* Erase a specific `Customer Profile`.

### Into the search `Car Profile` page will be able to do the following:

* Search a specific `Car Profile` and visualize it.

* Erase a specific `Customer Profile`.

### Into the details `Car Profile` page will be able to do the following:

* Details of the `Worksheet` will be presented.

* Different works, from the `Worksheet`, could be edited.

* New works could be added to the `Worksheet`.

* Erase a specific `Worksheet`.
