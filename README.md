# Inpost API Integration in Symfony Application

This Symfony application serves as a solution for the technical task assigned by Apilo sp. z o.o. The task involves creating an object-oriented PHP application that maps a JSON file's structure to classes with get/set methods, using deserialization. Additionally, the application connects to the Inpost API to retrieve points based on the provided city, and a CLI command facilitates the interaction.

## Features

- **CLI Integration**: Execute the application through the command line, providing the resource name (e.g., "points") and the city (e.g., "Kozy").
- **API Interaction**: Utilize Symfony HTTP Client to connect to the Inpost API (https://api-shipx-pl.easypack24.net/v1/points?city=Kozy).
- **Data Handling**: Deserialize API response using Symfony Serializer, mapping relevant information such as count, page, totalPages, and details of each item.
- **Object-Oriented Approach**: The application is built using Object-Oriented Programming principles, allowing for future expansion with additional methods/mappings.
- **Test-Driven Development (TDD)**: Implement unit tests for robust and reliable code.
- **Form-Based Search**: Extend the application to include an HTML form for searching pickup points based on street, city, and postal code.
- **Form Validation**: Apply Symfony Form and validators for input fields (e.g., street, city, postal code) with appropriate constraints.
- **Form Transformation**: Utilize Form Transformers to manipulate search entries (e.g., convert "KOZY" or "kozy" to "Kozy").
- **Result Display**: Customize the form to query the Inpost API based on the city, ignoring street and postal code. Display the results with additional information if a street and postal code are provided.

## Getting Started

To start the project, follow these steps:

1. Run the following command to build the Docker container and install dependencies:

```bash
make start
```

2. Start the Docker container:

```bash
make up
```

Access the container's console:

```bash
make console
```

## Run app

Run command
```bash
/var/www# $ php bin/console inpostApi points Kozy`
```
Run web app
```bash
http://localhost:8000/
```
Run test
```bash
var/www# php bin/phpunit
```
