# Pokemon Backend

Pokemon Backend is a project written in PHP with Laravel Framework.
It calls Pokémon APIs and Fun Translation API to retrieve Shakespeare description of a Pokémon.
It uses Redis to store cache of retrieved Pokemons.

## Prerequisites

To run the project you should have installed:

[Docker](https://www.docker.com)

[make](https://www.gnu.org/software/make/) You could [install it with Brew in Mac](https://formulae.brew.sh/formula/make)

## Run

To run the server review commands in Makefile.

To start it:

```bash
make start
```

Docker will expose the port 80.

Please check for any active firewall or port blocking in the OS or your software.

## Usage

To use the API you can use it via postman. 

*There is an openAPI documentation created for this API, inside public/docs folder.*

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
No license provided.
