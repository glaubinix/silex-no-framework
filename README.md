[![Build Status](https://travis-ci.org/glaubinix/silex-no-framework.svg?branch=master)](https://travis-ci.org/glaubinix/silex-no-framework)
# silex-no-framework

This library mostly contains silex ServiceProviders for the [QafooLabsNoFrameworkBundle](https://github.com/QafooLabs/QafooLabsNoFrameworkBundle). Only use what you want to use.

## Features
All supported features have a sample file in the examples folder and web test cases in the tests folder.

### Exception Converter
Maps uncaught exceptions to other exceptions or status codes.

See [convert_exception example file](examples/convert_exception.php).

No additional libraries necessary.

### Redirect Route
Return a RedirectRoute from controller methods, only using the route name and parameters. The response will be converted to a RedirectResponse.

See [redirect_route example file](examples/redirect_route.php).

No additional libraries necessary.

### Param Converter
Allows inject of TokenContext, FormRequest, Flash and Session via ParamConverter into controller methods.

See [param_converter example file](examples/param_converter.php).

Install symfony/security for usage of TokenContext with symfony security.
Install symfony/form for usage of FormRequest with symfony form.

### Return ViewModels, TemplateViews or arrays from controller
Tries to guess the template name base on controller and method name or for the TemplateView uses the template name which is provided. For ViewModels the object will be available as view variable in the template.

See [view example file](examples/view.php).

Install twig/twig and glaubinix/silex-twig-engine for usage with twig. You can also use another template engine. Simply register a service which implements the Symfony\Component\Templating\EngineInterface.
