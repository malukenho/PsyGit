PsyGit - Git for PHPsychopaths :construction_worker: [WIP]
==========================================================

<table border="0">
    <tr>
        <td>
            <img alt="PsyGit - git for PHPsychopaths" src="./psy-git.jpg" />
        </td>
        <td>
            <p>If you're doing something miraculous with php and git. Here's a good interface to work with.</p>
            <p><strong>PsyGit</strong> provides an easy way to work with git commands and manipulate your local repository, 
            without leaving your code <del>so</del> horrible.
            </p>
        </td>
    </tr>
</table>
    
---

<table>
    <tr>
        <td>
            <a href="#installation">Installation</a>
        </td>
        <td>
            <a href="#standalone">Standalone</a>
        </td>
        <td>
            <a href="#cqrs">CQRS</a>
        </td>
        <td>
            <a href="#">Fluent Interface</a>
        </td>
        <td>
            <a href="#commands">Commands</a>
        </td>
    </tr>
</table>


### Installation

It's can simply be installed by composer.

```sh
$ composer require malukenho/psygit
```

Now you can use the repository manager and start interact with your Repository.

```php
(PsyGit\RepositoryManager::fromDirectory('project-repository'))
    ->trackFile('changelog.txt')
        ->commit('Changelog updated automatically 8 A.M.')
            ->push('origin', 'master', \PsyGit\Command\Push::PUSH_FORCE);
```

### Standalone
### CQRS
### Fluent Interface
### Commands
