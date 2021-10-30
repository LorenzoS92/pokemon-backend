# Pokemon Backend

Pokemon Backend is a project written in PHP with [Laravel 8](https://laravel.com/).

It calls Pokémon APIs and Fun Translation API to retrieve Shakespeare description of a Pokémon.

It uses Redis to handles cache of Pokemons and avoid calling APIs.

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

*There is an openAPI documentation created for this API, inside public/docs folder.*

The project provides a Makefile for running commands: start, stop, test, shell, share.

Commands are launched via [Sail](https://laravel.com/docs/8.x/sail)

To run integrations and unit tests:

```bash
make test
```

To stop it: 
```bash
make stop
```

To share instance to public url:

```bash
make share
```

To launch shell

```bash
make share
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
No license provided.
