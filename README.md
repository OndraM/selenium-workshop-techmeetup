# Napište si první end-to-end test pro Selenium

Workspace na [3. TechMeetupu v Ostravě](https://www.meetup.com/TechMeetupOstrava/events/248997836/) 23. května 2018.

Během workshopu si zkusíme napsat jednoduchý end-to-end (alias funkční) test, který bude automatizovaně kontrolovat, že na nějakém webu funguje námi definovaný scénář.
A ukážeme si, jak tento test spouštět ve skutečném prohlížeči. U toho využijeme mj. tyto knihovny a technologie:
 - [Selenium](https://github.com/SeleniumHQ/selenium) - nástroj pro cross-browser automatizaci,
 - [php-webdriver](https://github.com/facebook/php-webdriver) - PHP adaptér pro Selenium protokol,
 - [PHPUnit](https://github.com/sebastianbergmann/phpunit) testovací framework
 - a [Steward](https://github.com/lmc-eu/steward), nástroj mj. na hromadné spouštění testu.

## Prerekvizity pro účastníky

Abychom maximálně využili čas workshopu pro samotnou ukázku práce se Seleniem a nezdržovali se na místě rozebíháním prostředí,
prosím **předem** si u sebe na počítači připravte následující.

**Budete potřebovat:**

- vlastní počítač
- [Docker](https://docs.docker.com/install/) (ve kterém budeme spouštět Selenium a prohlížeč)
- VNC klienta pro připojení k prohlížeči (k tomu, který poběží uvnitř Dockeru) - na Linuxu např. `vncviewer` (součást `TightVNC`) nebo [Remmina](https://www.remmina.org/), na Mac OS by měl stačit vestavěný VNC klient.
- lokálně nainstalovaný shell typu bash/zsh/etc. (na Windows použijte např. [Git BASH](https://git-for-windows.github.io/), cmd.exe nestačí)
- lokálně nainstalovaný Git
- lokálně nainstalované PHP 7.1 / 7.2 spustitelné z příkazové řádky (není třeba Apache, nginx atd.)
    - příkaz `php` musí jít z vašeho shellu spustit
    - na Windows je možné, že budete potřebovat cestu k php do systémové PATH proměnné, [návod viz zde](https://stackoverflow.com/questions/17727436/how-to-properly-set-php-environment-variable-to-run-commands-in-git-bash)
- lokálně nainstalovaný [composer](https://getcomposer.org/)
    - v shellu musí fungovat příkaz `composer
- IDE s podporou PHP (např. PhpStorm)

- Abyste ověřili, že vše funguje, jak má, vyzkoušejte si naklonovat zkušební repozitář:

```sh
$ git clone git@github.com:lmc-eu/steward-example.git
# pokud to nepůjde (když nemáte na GitHubu nastavený SSH klíč), zkuste:
$ git clone https://github.com/lmc-eu/steward-example.git
```

- Následně ve zkušebním repozitáři zkuste pomocí Composeru nainstalovat nezbytné knihovny:
```sh
$ cd steward-example
$ composer install
```

- A teď už jen nahoďte Docker image [standalone-chrome-debug](https://hub.docker.com/r/selenium/standalone-chrome-debug/):

```sh
$ docker run -p 4444:4444 -p 5900:5900 selenium/standalone-chrome-debug:3.6.0
```
**⚠ Docker image má skoro 400 MB, takže tento příkaz ⤴ určitě spusťte předem!**

Předchozí příkaz udělá, že Selenium poslouchá na lokálním portu `4444` a na portu `5900` je zase pro VNC otevřené grafické rozhraní.
Abyste se do grafického rozhraní dostali, připojte se vaším VNC klientem (viz výše) na adresu `127.0.0.1:5900`.

```sh
# Na Linuxu přes `vncviewer`:
$ vncviewer 127.0.0.1:5900 # pokud se zeptá na heslo, zadejte 'secret'
# Na Mac OS:
$ open vnc://127.0.0.1:5900
```

Pokud uvidíte prázdnou plochu s logem Ubuntu na černém pozadí, prostředí pro spouštění Selenium testů máte připravené. 🎉

Pro zastavení Dockeru můžete stisknout `Ctrl+C` v shellu, kde jste Docker před tím spouštěli.

Ale ještě, než Docker zastavíte:

### Vyzkoušejte, že vše běží 🚀

Zkusíme spustit pár ukázkových testů tímto příkazem:

```sh
# následující spouštějte uvnitř adresáře steward-example (viz výše)
$ ./vendor/bin/steward run production chrome -vv
```

Hned po spuštění tohoto příkazu se přepněte do okna VNC klienta, kde byste měli vidět, jak se otevírají Seleniem kontrolovaná okna prohlížeče.

Pokud je to tak, pak máte vše připraveno 👍.

### Narazili jste na potíže?

Pokud narazíte na potíže při rozebíhání vašeho prostředí pro workshop, prosím
[vytvořete issue](https://github.com/OndraM/selenium-workshop-techmeetup/issues/new) s popisem problému - co nejdříve vám zkusím pomoci.
