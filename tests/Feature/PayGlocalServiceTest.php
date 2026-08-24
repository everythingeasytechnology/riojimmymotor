<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Services\PayGlocalService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionMethod;
use Tests\TestCase;

class PayGlocalServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_key_content_normalizes_private_key_files_with_escaped_newlines(): void
    {
        $privateKeyPem = $this->samplePrivateKeyPem();

        $directory = storage_path('framework/testing/payglocal');
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($directory . '/private.pem', str_replace("\n", "\\n", $privateKeyPem));

        $service = $this->makeService();
        $keyContent = $this->invokeGetKeyContent($service, 'framework/testing/payglocal/private.pem');

        $this->assertSame($privateKeyPem, $keyContent);
    }

    public function test_get_key_content_accepts_inline_pem_values(): void
    {
        $privateKeyPem = $this->samplePrivateKeyPem();

        $service = $this->makeService();
        $keyContent = $this->invokeGetKeyContent($service, str_replace("\n", "\\n", $privateKeyPem));

        $this->assertSame($privateKeyPem, $keyContent);
    }

    public function test_get_key_content_decodes_base64_wrapped_pem_values(): void
    {
        $privateKeyPem = $this->samplePrivateKeyPem();

        $service = $this->makeService();
        $keyContent = $this->invokeGetKeyContent($service, base64_encode($privateKeyPem));

        $this->assertSame($privateKeyPem, $keyContent);
    }

    public function test_private_key_candidates_wrap_headerless_base64_key_bodies(): void
    {
        $service = $this->makeService();
        $candidates = $this->invokePrivateKeyCandidates($service, str_repeat('QUJD', 40));

        $this->assertContains(
            "-----BEGIN PRIVATE KEY-----\n" . chunk_split(str_repeat('QUJD', 40), 64, "\n") . "-----END PRIVATE KEY-----\n",
            $candidates
        );
    }

    private function makeService(): PayGlocalService
    {
        $this->configurePayGlocal('public.pem', 'private.pem');

        return new PayGlocalService();
    }

    private function configurePayGlocal(string $publicKeySource, string $privateKeySource): void
    {
        Setting::setValue('payment_payglocal_merchant_id', 'MID-TEST-123');
        Setting::setValue('payment_payglocal_public_key_id', 'PUBLIC-KID-123');
        Setting::setValue('payment_payglocal_private_key_id', 'PRIVATE-KID-123');
        Setting::setValue('payment_payglocal_public_key_path', $publicKeySource);
        Setting::setValue('payment_payglocal_private_key_path', $privateKeySource);
        Setting::setValue('payment_payglocal_base_url', 'https://sandbox.payglocal.in');
    }

    /**
     * Invoke the private key loader helper directly to keep the test deterministic.
     */
    private function invokeGetKeyContent(PayGlocalService $service, string $source): ?string
    {
        $method = new ReflectionMethod($service, 'getKeyContent');
        $method->setAccessible(true);

        return $method->invoke($service, $source);
    }

    /**
     * @return array<int, string>
     */
    private function invokePrivateKeyCandidates(PayGlocalService $service, string $source): array
    {
        $method = new ReflectionMethod($service, 'privateKeyCandidates');
        $method->setAccessible(true);

        return $method->invoke($service, $source);
    }

    private function samplePrivateKeyPem(): string
    {
        return <<<PEM
-----BEGIN PRIVATE KEY-----
line-one
line-two
-----END PRIVATE KEY-----
PEM . "\n";
    }
}
