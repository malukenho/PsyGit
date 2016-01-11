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

namespace PsyGitTest\Command;

use PsyGit\Command\InitializeRepository;
use Symfony\Component\Process\Process;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 *
 * @covers \PsyGit\Command\InitializeRepository
 */
final class InitializeRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanInitializeRepositoryInAPath()
    {
        $directory = sys_get_temp_dir() . '/' . microtime(true);

        mkdir($directory);

        self::assertFileNotExists($directory . '/.git');

        (new InitializeRepository(function ($command) use ($directory) {
            $process = new Process($command, $directory);

            return $process->run();
        }))
            ->__invoke();

        self::assertFileExists($directory . '/.git');
    }
}
