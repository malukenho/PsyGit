<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

declare(strict_types=1);

namespace PsyGit\Command;

/**
 * Command to clone a git repository to a directory {@link https://git-scm.com/docs/git-clone}
 *
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class CloneRepository
{
    const BRANCH_MASTER = 'master';

    /**
     * @var callable
     */
    private $commandHandler;

    /**
     * @param callable $commandHandler
     */
    public function __construct(callable $commandHandler)
    {
        $this->commandHandler = $commandHandler;
    }

    public function __invoke(string $repository, string $destination, string $branch = self::BRANCH_MASTER)
    {
        $commandHandler = $this->commandHandler;

        $repository  = escapeshellarg($repository);
        $destination = escapeshellarg($destination);
        $branch      = escapeshellarg($branch);

        return $commandHandler("git clone -b $branch $repository $destination");
    }
}
