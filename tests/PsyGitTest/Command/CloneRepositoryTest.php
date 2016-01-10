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

use PsyGit\Command\CloneRepository;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 *
 * @covers \PsyGit\Command\CloneRepository
 */
final class CloneRepositoryTest extends \PHPUnit_Framework_TestCase
{
    const REPOSITORY_URL = 'https://github.com/malukenho/speaknumber';

    public function testCanCloneARepository()
    {
        $destination = sys_get_temp_dir() . '/' . microtime(true);

        (new CloneRepository(function ($command) {
                exec($command);
        }))
            ->__invoke(self::REPOSITORY_URL, $destination);

        self::assertFileExists($destination . '/.git');
    }
}
